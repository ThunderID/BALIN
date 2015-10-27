<?php 
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response;

class HomeController extends baseController
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		parent::__construct();
	}

	protected $view_name 		= 'Home';
	
	public function index()
	{
		$breadcrumb				= [];

		$this->layout->page 	= view('pages.backend.home.index')
									->with('WT_pageTitle', $this->view_name)
									->with('WT_pageSubTitle','Index')
									->with('WB_breadcrumbs', $breadcrumb)
									->with('nav_active', 'dashboard')
									->with('subnav_active', 'dashboard');
		return $this->layout;
	}
}
