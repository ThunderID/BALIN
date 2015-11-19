<?php 
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response, Auth;

class HomeController extends BaseController
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		parent::__construct();
	}

	protected $view_name 		= 'Dashboard';
	
	public function index()
	{
		switch(strtolower(Auth::user()->role))
		{
			case 'store_manager';
				$view 			= 'store_manager';
			break; 
			case 'admin';
				$view 			= 'admin';
			break; 
			default;
				$view 			= 'staff';
			break; 
		}
		
		$breadcrumb				= [];

		$this->layout->page 	= view('pages.backend.home.'.$view.'.index')
									->with('WT_pagetitle', $this->view_name)
									->with('WT_pageSubTitle','')
									->with('WB_breadcrumbs', $breadcrumb)
									->with('nav_active', 'dashboard')
									->with('subnav_active', 'dashboard');
		return $this->layout;
	}
}
