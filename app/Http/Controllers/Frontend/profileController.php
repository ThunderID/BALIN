<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\baseController;

class profileController extends baseController 
{

	protected $controller_name 					= 'profile';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.profile')->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}