<?php 
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use Input, Session, DB, Redirect, Response, Auth;

class ErrorController extends BaseController
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		parent::__construct();
	}

	protected $view_name 		= 'Error';
	
	public function error_404()
	{
		
		$breadcrumb				= [];

		$this->layout->page 	= view('pages.backend.error.404')
									->with('WT_pagetitle', '')
									->with('WT_pageSubTitle','')
									->with('WB_breadcrumbs', $breadcrumb)
									->with('nav_active', '')
									->with('subnav_active', '');
		return $this->layout;
	}
}
