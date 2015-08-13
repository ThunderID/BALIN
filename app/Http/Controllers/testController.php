<?php namespace App\Http\Controllers;

use App\Http\Controllers\baseController;

class testController extends baseController 
{
	protected $controller_name 					= 'test';

	public function error()
	{		
		$this->layout->page 					= view('pages.error')
													->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}