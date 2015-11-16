<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Models\Varian;
use App\Models\Transaction;
use App\Jobs\SaveToTransactionDetail;
use Input, Response, Redirect, Cookie, Auth, Request;

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
		$baskets 								= Request::cookie('baskets');

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
		$baskets 								= Cookie::forever('baskets', $baskets);

		return Redirect::route('frontend.cart.index')
						->withCookie($baskets);
	}

	public function edit ()
	{
		$baskets 								= Request::cookie('baskets');
		$carts 									= null;
		$this->layout->page 					= view('pages.frontend.cart.edit')
														->with('controller_name', $this->controller_name)
														->with('carts', $carts);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function update($cid = null, $vid = null)
	{

		$baskets 									= Request::cookie('baskets');

		$inputs 									= Input::only('qty');


		$baskets[$cid]['varians'][$vid]['qty']		= $inputs['qty'][$vid];


		// $inputs 									= Input::all();

		// //get current stock
		// $baskets 									= Request::cookie('baskets');

		// $qty 										= Input::get('product_qty');

		// foreach ($inputs  as $k => $input)
		// {
		// 	if($k != '_token')
		// 	{
		// 		foreach ($input as $key => $value) 
		// 		{
		// 			// $baskets[$k]['varians'][$key]['qty'] = $value;
		// 			$varians 							= 	[
		// 														'varian_id' 	=> $baskets[$k]['varians'][$key]['varian_id'], 
		// 														'qty' 			=> $qty[$k],
		// 														'size' 			=> $baskets[$k]['varians'][$key]['size'], 
		// 														'stock' 		=> $baskets[$k]['varians'][$key]['stock']
		// 													];
		// 		}

		// 		$baskets[$k]							=	[
		// 														'slug' 			=> $baskets[$k]['slug'], 
		// 														'name'			=> $baskets[$k]['name'],
		// 														'stock'			=> $baskets[$k]['stock'],
		// 														'price'			=> $baskets[$k]['price'],
		// 														'discount'		=> $baskets[$k]['discount'],
		// 														'images'		=> $baskets[$k]['images'],
		// 														'varians'		=> $varians
		// 													];				
		// 	}
		// }
		// dd($vid);

		Cookie::forget('baskets');

		// dd($baskets);
		// //update baskets
		$baskets 								= Cookie::forever('baskets', $baskets);


		//return cookies
		return Redirect::route('frontend.cart.index')
						->withCookie($baskets);
	}

	// FUNCTION REMOVE CART
	public function destroy ($cid = null, $vid = null)
	{
		//get old baskets
		$baskets 								= Request::cookie('baskets');

		//check validation
		// if ($cid)
		// {
		// 	// return false;
		// 	dd('wrong');
		// }

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
		$baskets 								= Cookie::forever('baskets', $baskets);

		//return cookies
		return Redirect::route('frontend.cart.index')
						->withCookie($baskets);
	}


	// FUNCTION EMPTY CART
	public function clean()
	{
		return Redirect::route('frontend.cart.index')
						->withCookie(Cookie::forget('baskets'));		
	}
}