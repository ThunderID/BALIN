<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

class HomeController extends BaseController 
{

	protected $controller_name 					= 'home';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.home.index')
													->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}