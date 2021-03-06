<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Input, Redirect, Auth, Carbon, Validator, DB, App;
use Illuminate\Support\MessageBag;

use App\Models\User;
use App\Models\PointLog;

class JoinController extends BaseController 
{
	protected $controller_name 					= 'join';

	public function index()
	{	
		if(Auth::check())
		{
			return Redirect::route('frontend.user.index');
		}

		$breadcrumb										= ['Sign In' => route('frontend.join.index')];
		$this->layout->page 							= view('pages.frontend.login.index')
																->with('controller_name', $this->controller_name)
																->with('breadcrumb', $breadcrumb)
																;
		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Sign In';

		return $this->layout;
	}
}