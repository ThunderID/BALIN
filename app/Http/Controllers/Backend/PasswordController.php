<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use App\Models\User;
use Input, Session, DB, Redirect, Response, Auth;

class PasswordController extends baseController 
{
	protected $view_name 			= 'Password';

	public function create()
	{ 
		$breadcrumb								= ['Ganti Password' => 'backend.changePassword'];

		$this->layout->page 					= view('pages.backend.password.create')
															->with('WT_pageTitle', $this->view_name )
															->with('WT_pageSubTitle','Index')
															->with('WB_breadcrumbs', $breadcrumb)
															->with('nav_active', null)
															->with('subnav_active', null);

		return $this->layout;
	}

	public function store($id = null)
	{
		
	}
}