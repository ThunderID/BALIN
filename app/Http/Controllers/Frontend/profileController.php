<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\baseController;

class profileController extends baseController 
{

	protected $controller_name 					= 'profile';

	public function index()
	{		
		$this->layout->page 					= view('pages.frontend.profile')
													->with('controller_name', $this->controller_name)
													->with('subPage', 'profileDetail');
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function membershipDetail()
	{		
		$this->layout->page 					= view('pages.frontend.profile')
													->with('controller_name', $this->controller_name)
													->with('subPage', 'membershipDetail');
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function changePassword()
	{		
		$this->layout->page 					= view('pages.frontend.profile')
													->with('controller_name', $this->controller_name)
													->with('subPage', 'profileChangePassword');
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}	

	public function changeProfile()
	{		
		$this->layout->page 					= view('pages.frontend.profile')
													->with('controller_name', $this->controller_name)
													->with('subPage', 'profileEdit');
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}	
}