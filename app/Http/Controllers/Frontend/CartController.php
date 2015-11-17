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
		$carts 									= null;
		$this->layout->page 					= view('pages.frontend.cart.index')
													->with('controller_name', $this->controller_name)
													->with('carts', $carts);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	// FUNCTION ADD TO CART
	public function store($slug = null)
	{
		$baskets 								= Session::get('baskets');

		$slug									= Input::get('product_slug');

		$product 								= Product::slug($slug)->first();

		$basket['slug']							= $product->slug;
		$basket['name']							= $product->name;
		$basket['price']						= $product->price;
		$basket['discount']						= $product->discount;
		$basket['stock']						= $product->stock;
		$basket['images']						= $product->default_image;

		$varians 								= Input::get('varianids');
		$qtys 									= Input::get('qty');

		$varian 								= [];

		foreach ($varians as $key => $value) 
		{
			if(isset($qtys[$key]) && $qtys[$key]!=0)
			{
				$varianp 						= Varian::findorfail($value);

				$varian[]						= ['varian_id' => $varianp->id, 'qty' => $qtys[$key], 'size' => $varianp->size, 'stock' => $varianp->stock];
			}
		}

		$basket['varians']						= $varian;

		$baskets[$product->id]					= $basket;

		if(Auth::check())
		{
			$price 								= ['price' => $basket['price'], 'discount' => $basket['discount']];
			$transaction           	 			= Transaction::userid(Auth::user()->id)->status('cart')->first();

			if($transaction)
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

			if($result->getStatus()=='error')
			{
				return Redirect::route('frontend.cart.index')->withErrors($result->getErrorMessage());
			}
		}

		//update baskets
		$carts 									= Session::put('baskets', $baskets);

		return Response::json(['carts' => $baskets], 200);
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

		$inputs 									= Input::only('qty');

		$baskets[$cid]['varians'][$vid]['qty']		= $inputs['qty'][$vid];

		Session::forget('baskets');

		$carts 										= Session::put('baskets', $baskets);

		return Response::json(['carts' => $baskets], 200);
	}

	// FUNCTION REMOVE CART
	public function destroy ($cid = null, $vid = null)
	{
		//get old baskets
		$baskets 								= Session::get('baskets');

		if(isset($cid) && !isset($vid))
		{
			//remove selected item from cart
			unset($baskets[$cid]);
		}
		else if (isset($cid) && isset($vid)) 
		{
			//remove varian from selected item cart
			if(count($baskets[$cid]['varians']) > 1)
			{
				unset($baskets[$cid]['varians'][$vid]);
			}
			else
			{
				unset($baskets[$cid]);
			}
		}

		// //update baskets
		$carts 								= Session::put('baskets', $baskets);

		return Response::json(['carts' => $baskets], 200);
	}


	// FUNCTION EMPTY CART
	public function clean()
	{
		return Redirect::route('frontend.cart.index')
						->withSession(Session::forget('baskets'));		
	}

	public function getListBasket() 
	{
		return View('widgets.frontend.top_menu.item_cart_dropdown');
	}
}