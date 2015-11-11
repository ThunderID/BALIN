<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

class AboutUsController extends BaseController 
{

	protected $controller_name 					= 'aboutus';

	public function index()
	{		
		$breadcrumb								= ['About Us' => route('frontend.aboutus.index')];
		$this->layout->page 					= view('pages.frontend.about_us.index')
													->with('controller_name', $this->controller_name)
													->with('breadcrumb', $breadcrumb)
													;
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}