<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Models\Varian;
use App\Models\Transaction;
use App\Jobs\SaveToTransactionDetail;
use Input, Response, Redirect, Cookie, Auth;

class CartController extends BaseController 
{
	protected $controller_name 					= 'cart';

	public function index()
	{	
		$baskets = Cookie::get('basketss');
	
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
		$baskets 								= Cookie::get('baskets');

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
		$baskets 								= Cookie::make('baskets', $baskets, 1440);

		return Redirect::route('frontend.cart.index')
						->withCookie($baskets);
	}

	public function edit ()
	{
		$baskets 								= Cookie::get('baskets');
		$carts 									= null;
		$this->layout->page 					= view('pages.frontend.cart.edit')
														->with('controller_name', $this->controller_name)
														->with('carts', $carts);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function update()
	{
		//get current stock
		$baskets 								= Cookie::get('baskets');

		$qty 										= Input::get('product_qty');

		foreach ($baskets as $k => $item)
		{
			$basket[$k]							=	[
														'slug' 			=> $item['slug'], 
														'name'			=> $item['name'],
														'sku'				=> $item['sku'],
														'qty' 			=> $qty[$k],
														'stock'			=> $item['stock'],
														'price'			=> $item['price'],
														'discount'		=> $item['discount'],
														'images'			=> $item['images']
													];
		}

		Cookie::forget('baskets');

		$baskets 								= $basket;

		//update baskets
		$baskets 								= Cookie::make('baskets', $baskets, 1440);

		//return cookies
		return Redirect::route('frontend.cart.index')
						->withCookie($baskets);
	}

	// FUNCTION REMOVE CART
	public function destroy ($id)
	{
		//get old baskets
		$baskets 								= Cookie::get('baskets');

		//check validation
		if ($id && count($baskets) <= $id )
		{
			return false;
			// dd($wrong);
		}

		//remove selected item from cart
		unset($baskets[$id]);

		$baskets 								= array_values(array_filter($baskets));

		//update baskets
		$baskets 								= Cookie::forever('baskets', $baskets);

		//return cookies
		return Redirect::route('frontend.cart.index')
						->withCookie($baskets);
	}
}