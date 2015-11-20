<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Models\Varian;
use App\Models\Transaction;
use App\Jobs\SaveToTransactionDetail;
use Input, Response, Redirect, Session, Auth, Request;

class CartController extends BaseController 
{
	protected $controller_name 					= 'cart';

	public function index()
	{	
		$breadcrumb								= ['Cart' => route('frontend.cart.index')];
		$carts 									= null;
		$this->layout->page 					= view('pages.frontend.cart.index')
													->with('controller_name', $this->controller_name)
													->with('breadcrumb', $breadcrumb)
													->with('carts', $carts);
		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Shopping Cart';

		return $this->layout;
	}

	// FUNCTION ADD TO CART
	public function store($slug = null)
	{
		$baskets 								= Session::get('baskets');
		$slug									= Input::get('product_slug');
		$product 								= Product::slug($slug)->with('prices')->first();
		$qty 									= Input::get('qty');
		$varianids 								= Input::get('varianids');

		if (empty($baskets))
		{
			$temp_basket 						= $this->addToCart($baskets, $product, $qty, $varianids);
		}
		else
		{
			if (in_array($product['id'], $baskets)) 
			{
				$temp_basket 					= $this->addToCart($baskets, $product, $qty, $varianids);
			}
			else 
			{
				$temp_basket 					= $this->addToCart($baskets, $product, $qty, $varianids);		
			}
		}
			
			//update baskets
		$carts 									= Session::put('baskets', $temp_basket);

		return Response::json(['carts' => $temp_basket], 200);
	}

	public function edit ()
	{
		$baskets 								= Session::get('baskets');
		$carts 									= null;
		$this->layout->page 					= view('pages.frontend.cart.edit')
														->with('controller_name', $this->controller_name)
														->with('carts', $carts);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function update($cid = null, $vid = null)
	{
		$baskets 									= Session::get('baskets');
		$baskets[$cid]['varians'][$vid]['qty']		= Input::get('qty');

		Session::forget('baskets');

		$carts 										= Session::put('baskets', $baskets);

		return Response::json(['carts' => $baskets], 200);
	}

	// FUNCTION REMOVE CART
	public function destroy ()
	{
		//get old baskets
		$baskets 									= Session::get('baskets');
		$cid 										= Input::get('cid');
		$vid 										= Input::get('vid');

		if (isset($cid) && !isset($vid))
		{
			// remove selected item from cart
			unset($baskets[$cid]);
		}
		else if (isset($cid) && isset($vid)) 
		{
			// remove varian from selected item cart
			if (count($baskets[$cid]['varians']) > 1)
			{
				unset($baskets[$cid]['varians'][$vid]);
			}
			else
			{
				unset($baskets[$cid]);
			}
		}

		// update baskets
		$carts 								= Session::put('baskets', $baskets);

		return Response::json(['carts' => $baskets], 200);
	}


	// FUNCTION EMPTY CART
	public function clean()
	{
		return Redirect::route('frontend.product.index')
						->withSession(Session::forget('baskets'));		
	}

	public function getListBasket() 
	{
		return View('widgets.frontend.top_menu.item_cart_dropdown');
	}

	function addToCart($baskets, $product, $qty, $varianids) 
	{
		$basket['slug']							= $product->slug;
		$basket['name']							= $product->name;
		$basket['discount']						= $product->discount;
		$basket['stock']						= $product->stock;
		$basket['images']						= $product->default_image;
		$price 									= $product['price'];
		$msg 									= null; 						

		if ($product['discount']!=0) 
		{
			$price 								= $product['promo_price'];
		}

		$basket['price']						= $price;

		$varians 								= Input::get('varianids');

		$qtys 									= Input::get('qty');

		$varian 								= [];
		$temp_basket 							= Session::get('baskets');

		foreach ($varians as $key => $value) 
		{
			// if(isset($temp_basket[$product->id]))
			// {
			// 	$now_qty 						= $qtys[$key]+$temp_basket[$product['id']]['varians'][$key]['qty']
			// }
				if (isset($qtys[$key]) && $qtys[$key]!=0 && isset($temp_basket[$product['id']]['varians'][$key]))
				{
					$validqty 		= $qtys[$key]+$temp_basket[$product['id']]['varians'][$key]['qty'];
				}
				elseif(isset($temp_basket[$product['id']]['varians'][$key]))
				{
					$validqty 		= $temp_basket[$product['id']]['varians'][$key]['qty']; 
				}
				else
				{
					$validqty 		= $qtys[$key];
				}

				$varianp 			= Varian::findorfail($value);

				if ($varianp->stock < $validqty && ($varianp->stock!=0))
				{
					$msg 			= 'Maaf stock tidak mencukupi';
					$validqty 		= $qtys[$key];
				}
				else
				{
					$msg 			= null;
				}

				$varian[]						= [	'varian_id' => $varianp->id, 
													'qty' 		=> $validqty, 
													'size' 		=> $varianp->size, 
													'stock' 	=> $varianp->stock,
													'message'   => $msg
													];
		}
		$basket['varians']						= $varian;

		$baskets[$product->id]					= $basket;

		if (Auth::check())
		{
			$price 								= ['price' => $basket['price'], 'discount' => $basket['discount']];
			$transaction           	 			= Transaction::userid(Auth::user()->id)->status('cart')->first();

			if (!is_null($transaction['id']))
			{
				$result                 		= $this->dispatch(new SaveToTransactionDetail($transaction, $varian, $price));
			}
			else
			{
				$transaction 					= new Transaction;
				$transaction->fill([
					'user_id'               	=> Auth::user()->id,
					'type'                  	=> 'sell',
					]);

				if($transaction->save())
				{
					$result                 	= $this->dispatch(new SaveToTransactionDetail($transaction, $varian, $price));
				}
				else
				{
					$result 					= new JSend('success', (array)$transaction);
				}
			}

			if ($result->getStatus()=='error')
			{
				return Redirect::route('frontend.cart.index')->withErrors($result->getErrorMessage())->with('msg-type', 'danger');
			}
		}

		return $baskets;
	}
}