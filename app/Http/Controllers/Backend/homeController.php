<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;

class homeController extends baseController 
{
	protected $controller_name 					= 'index';

	public function index()
	{		
		$this->layout->page 					= view('pages.backend.home')
													->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}