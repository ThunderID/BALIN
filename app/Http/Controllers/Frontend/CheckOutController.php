<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\Transaction;
use Input, Response, Redirect, Cookie, Auth;

class CheckOutController extends BaseController 
{
	protected $controller_name 					= 'checkout';

	public function getCheckout()
	{	
		//get transaction
		$transaction           	 			= Transaction::userid(Auth::user()->id)->status('cart')->first();
		
		return $this->layout;
	}

	public function postCheckout()
	{
		return $this->layout;
	}
}