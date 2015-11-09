<?php 
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response;

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
		$breadcrumb				= [];

		$this->layout->page 	= view('pages.backend.home.index')
									->with('WT_pagetitle', $this->view_name)
									->with('WT_pageSubTitle','')
									->with('WB_breadcrumbs', $breadcrumb)
									->with('nav_active', 'dashboard')
									->with('subnav_active', 'dashboard');
		return $this->layout;
	}
}
