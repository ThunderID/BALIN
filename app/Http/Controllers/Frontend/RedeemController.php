<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Input, Redirect, Auth, Carbon, Validator, DB, App;
use Illuminate\Support\MessageBag;

use App\Models\Transaction;
use App\Models\User;

class RedeemController extends BaseController 
{
	protected $controller_name 					= 'redeem';

	public function index()
	{		
		$breadcrumb								= ['Redeem' => route('frontend.redeem.index')];

		$this->layout->page 					= view('pages.frontend.redeem_code.index')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'redeem')
													->with('title', 'Redeem Info')
													->with('breadcrumb', $breadcrumb);

		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Redeem Info';

		return $this->layout;
	}
}