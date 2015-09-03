<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;

class homeController extends baseController 
{
	protected $view_name 					= 'Home';

	public function index()
	{		
		$breadcrumb								= array();

		$this->layout->page 					= view('pages.backend.home')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Dashboard')
													->with('WB_breadcrumbs', $breadcrumb)
													;													

		return $this->layout;
	}
}