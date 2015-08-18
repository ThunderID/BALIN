<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\baseController;

class cartController extends baseController 
{
	protected $controller_name 					= 'cart';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.cart')->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}