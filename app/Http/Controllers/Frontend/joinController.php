<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

class joinController extends BaseController 
{

	protected $controller_name 					= 'join';

	public function index()
	{	
		$breadcrumb										= ['Sign In' => route('frontend.join.index')];
		$this->layout->page 							= view('pages.frontend.login.index')
																->with('controller_name', $this->controller_name)
																->with('breadcrumb', $breadcrumb)
																;
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}