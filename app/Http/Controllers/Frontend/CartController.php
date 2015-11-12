<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use Input, Response, Redirect, Cookie;

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
	public function store($slug = null , $qty = null)
	{
		$name 								= Input::get('product_name');
		$slug									= Input::get('product_slug');
		$qty 									= Input::get('product_qty');
		$price 								= Input::get('product_price');
		$discount 							= Input::get('product_discount');
		$stock 								= Input::get('product_stock');
		$size 								= Input::get('product_size');
		$images								= Input::get('product_image');

		if (!$slug || !$qty)
		{
			return Redirect::back()
						->with('msg','Size atau Kuantitas belum masih kosong')
						->with('msg-type', 'danger');
		}

		//get current stock
		$baskets = Cookie::get('baskets');


		//get addition cart
		$basket 								= 	[
														'slug' 			=> $slug, 
														'name'			=> $name,
														'qty' 			=> $qty,
														'stock'			=> $stock,
														'price'			=> $price,
														'discount'		=> $discount,
														'size'			=> $size,
														'images'			=> $images
													];
		// dd($basket);exit;
		//adding new data to basket 
		if (empty($baskets))
		{
			$basket 							= array($basket);
			$baskets 							= $basket;
		}
		else
		{
			array_push($baskets, $basket);
		}

		//update baskets
		$baskets 								= Cookie::make('baskets', $baskets, 1440);

		//return cookies
		// return Response::make('item added to cart')
		// 					->withCookie($baskets);
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