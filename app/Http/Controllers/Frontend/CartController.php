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
	public function store($id = null , $qty = null)
	{
		//test purpose 
		$id 				= Input::get('product_id');
		$qty 				= Input::get('product_qty');

		if (!$id && !$qty)
		{
			return false;
		}

		//get current stock
		$baskets = Cookie::get('baskets');


		$product 								= Product::where('id', $id)
														->with('images')
														->first();

		//get addition cart
		$basket 								= 	[
														'id' 			=> $id, 
														'name'			=> $product['name'],
														'sku'			=> $product['sku'],
														'qty' 			=> $qty,
														'price'			=> $product['price'],
														'promo_price'	=> $product['promo_price'],
														'discount'		=> $product['discount'],
														'images'		=> $product['images'][0]['thumbnail']
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
			// dd('other');
			// $basket 							= ['id' => $id, 'qty' => $qty];

			array_push($baskets, $basket);
		}

		//update baskets
		$baskets 								= Cookie::forever('baskets', $baskets);

		//return cookies
		// return Response::make('item added to cart')
		// 					->withCookie($baskets);
		return Redirect::route('frontend.cart.index')
						->withCookie($baskets);
	}

	// FUNCTION REMOVE CART
	public function destroy ($id = null)
	{
		//notes: ID from cart array. bukan product id

		//test purpose
		$id= 0;

		//get old baskets
		$baskets = Cookie::get('baskets');

		//check validation
		if($id && count($baskets) <= $id )
		{
			return false;
			dd($wrong);
		}

		//remove selected item from cart
		unset($baskets[$id]);
		$baskets = array_values(array_filter($baskets));

		//update baskets
		$baskets 			= Cookie::forever('baskets', $baskets);

		//return cookies
		return Response::make('item removed from cart')
							->withCookie($baskets);
	}
}