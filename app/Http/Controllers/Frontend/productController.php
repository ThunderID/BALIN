<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\baseController;

use Cookie, Response;

class productController extends baseController 
{

	protected $controller_name 					= 'product';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.product')->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}


	public function show($id = null)
	{
		$this->layout->page 					= view('pages.frontend.ProductDetail')
														->with('controller_name', $this->controller_name)
														->with('id', $id)
														;
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}


	public function addToCart($id = null , $qty = null)
	{
		//test purpose 
		$id ='aaaa1';
		$qty = 'bb1';

		if($id && $qty)
		{
			return false;
		}

		//get current stock
		$baskets = Cookie::get('baskets');

		//get addition cart
		$basket 								= array(['id' => $id, 'qty' => $qty]);

		//adding new data to basket 
		if(empty($baskets))
		{
			$basket 							= array(['id' => $id, 'qty' => $qty]);


			$baskets 							= $basket;
		}
		else
		{
			$basket 							= ['id' => $id, 'qty' => $qty];

			array_push($baskets, $basket);
		}

		//update baskets
		$baskets 			= Cookie::forever('baskets', $baskets);

		//return cookies
		return Response::make('item added to cart')
							->withCookie($baskets);
	}

	public function detail()
	{
		$baskets = Cookie::get('basketss');

		dd($baskets);
	}

	public function removeFromCart($id = null)
	{
		//notes: ID from cart array. bukan product id

		//test purpose
		$id= 1;

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
			