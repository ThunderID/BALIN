<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

class joinController extends BaseController 
{

	protected $controller_name 					= 'join';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.join')->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}