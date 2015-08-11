<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\baseController;

class chartController extends baseController 
{
	protected $controller_name 					= 'chart';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.chart')->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}