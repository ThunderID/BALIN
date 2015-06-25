<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\baseController;

class homeController extends baseController 
{

	protected $controller_name 					= 'home';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.home')->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}