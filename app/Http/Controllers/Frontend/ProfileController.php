<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\baseController;

class ProfileController extends baseController 
{

	protected $controller_name 					= 'profile';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.user.index')
													->with('controller_name', $this->controller_name)
													->with('sub_page', 'profile_detail');
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function membershipDetail()
	{		
		$this->layout->page 					= view('pages.frontend.user.index')
													->with('controller_name', $this->controller_name)
													->with('sub_page', 'membership_detail');
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function changePassword()
	{		
		$this->layout->page 					= view('pages.frontend.user.index')
													->with('controller_name', $this->controller_name)
													->with('sub_page', 'profile_change_password');
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}	

	public function changeProfile()
	{		
		$this->layout->page 					= view('pages.frontend.user.index')
													->with('controller_name', $this->controller_name)
													->with('sub_page', 'profile_edit');
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}	
}