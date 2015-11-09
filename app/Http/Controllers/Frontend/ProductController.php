<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\baseController;

use Cookie, Response;

class ProductController extends baseController 
{

	protected $controller_name 					= 'product';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.product.index')->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}


	public function show($slug = null)
	{
		$this->layout->page 					= view('pages.frontend.product.show')
														->with('controller_name', $this->controller_name)
														->with('slug', $slug)
														;
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function detail()
	{
		$baskets = Cookie::get('basketss');

		dd($baskets);
	}	
}