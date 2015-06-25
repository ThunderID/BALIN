<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\baseController;

class productController extends baseController 
{

	protected $controller_name 					= 'product';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.product')->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}