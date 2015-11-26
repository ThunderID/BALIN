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

		$product 								= Product::slug($slug)->currentprice(true)->sellable(true)->defaultimage(true)->first();

		$qty 									= Input::get('qty');
		$varianids 								= Input::get('varianids');

		$varians 								= [];
		$qtys 									= [];

		foreach ($varianids as $key => $value) 
		{
			$varians[$value] 					= $value;
			$qtys[$value]						= $qty[$key];
		}

		$temp_basket 							= $this->addToCart($baskets, $product, $qtys, $varians);

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
		$baskets 								= Session::get('baskets');
		$baskets[$cid]['varians'][$vid]['qty']	= Input::get('qty');
		$product 								= Product::id($cid)->currentprice(true)->sellable(true)->defaultimage(true)->first();
		$varianids[] 							= $vid;

		$temp_basket 							= $this->addToCart($baskets, $product, Input::get('qty'), $varianids);

		Session::forget('baskets');

		$carts 									= Session::put('baskets', $temp_basket);

		return Response::json(['carts' => $temp_basket], 200);
	}

	// FUNCTION REMOVE CART
	public function destroy ()
	{
		//get old baskets
		$baskets 									= Session::get('baskets');
		$cid 										= Input::get('cid');
		$vid 										= Input::get('vid');

		if (Auth::check())
		{
			$transaction           	 			= Transaction::userid(Auth::user()->id)->status('cart')->first();

			foreach ($transaction->transactiondetails as $key => $value) 
			{
				if($value->varian_id == $vid && !$value->delete())
				{
					return Redirect::route('frontend.cart.index')->withErrors($value->getError())->with('msg-type', 'danger');
				}
			}
		}

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
		if (Auth::check())
		{
			$transaction           	 			= Transaction::userid(Auth::user()->id)->status('cart')->first();

			foreach ($transaction->transactiondetails as $key => $value) 
			{
				if(!$value->delete())
				{
					return Redirect::route('frontend.cart.index')->withErrors($value->getError())->with('msg-type', 'danger');
				}
			}
		}

		return Redirect::route('frontend.product.index')
						->withSession(Session::forget('baskets'));		
	}

	public function getListBasket() 
	{
		return View('widgets.frontend.top_menu.item_cart_dropdown');
	}

	function addToCart($temp_basket, $product, $qtys, $varianids) 
	{
		$basket['slug']							= $product['slug'];
		$basket['name']							= $product['name'];
		$basket['discount']						= $product['discount'];
		$basket['stock']						= $product['stock'];
		$basket['images']						= $product['default_image'];
		$basket['price']						= $product['price'];

		$msg 									= null;
		$varian 								= [];

		foreach ($varianids as $key => $value) 
		{
			if (isset($qtys[$value]) && $qtys[$value]!=0 && isset($temp_basket[$product['id']]['varians'][$value]))
			{
				$validqty 		= $qtys[$value]+$temp_basket[$product['id']]['varians'][$value]['qty'];
			}
			elseif(isset($temp_basket[$product['id']]['varians'][$value]))
			{
				$validqty 		= $temp_basket[$product['id']]['varians'][$value]['qty']; 
			}
			else
			{
				$validqty 		= $qtys[$value];
			}

			$varianp 			= Varian::findorfail($value);

			if ($varianp['stock'] < $validqty && ($varianp['stock']!=0))
			{
				$msg 			= 'Maaf stock tidak mencukupi';
				$validqty 		= $qtys[$value];
			}
			else
			{
				$msg 			= null;
			}

			if($validqty >= 0)
			{
				$varian[$varianp['id']]		= [	'varian_id' => $varianp['id'], 
												'qty' 		=> $validqty, 
												'size' 		=> $varianp['size'], 
												'stock' 	=> $varianp['stock'],
												'message'   => $msg
												];
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

				if($validqty==0)
				{
					unset($varian[$varianp['id']]);
				}
			}
		}

		$basket['varians']						= $varian;
		$temp_basket[$product['id']]			= $basket;

		if(count($temp_basket[$product['id']]['varians'])==0)
		{
			unset($temp_basket[$product['id']]);
		}

		return $temp_basket;
	}
}