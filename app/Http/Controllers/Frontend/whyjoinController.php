<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

class whyjoinController extends BaseController 
{

	protected $controller_name 					= 'whyjoin';

	public function index()
	{		
		$breadcrumb								= ['Why Join' => route('frontend.whyjoin.index')];
		$this->layout->page 					= view('pages.frontend.why_join.index')
													->with('controller_name', $this->controller_name)
													->with('breadcrumb', $breadcrumb)
													;
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}
}