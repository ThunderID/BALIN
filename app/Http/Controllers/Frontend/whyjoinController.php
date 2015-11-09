<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

class whyjoinController extends BaseController 
{

	protected $controller_name 					= 'whyjoin';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.whyJoin')->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}