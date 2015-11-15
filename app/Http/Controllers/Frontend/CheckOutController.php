<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\Transaction;
use App\Models\Address;
use Input, Response, Redirect, Cookie, Auth;

class CheckOutController extends BaseController 
{
	protected $controller_name 					= 'checkout';

	public function getCheckout()
	{	
		//get transaction
		$baskets 								= Cookie::get('baskets');
		$addresses 								= Address::oldershipmentbycustomer(Auth::user()->id)->get()->toArray();
		$address 								= Address::ownerid(Auth::user()->id)->ownertype('App\Models\User')->first();
		$addresses[]							= $address;

		$this->layout->page 					= view('pages.frontend.cart.checkout')
													->with('controller_name', $this->controller_name)
													->with('carts', $baskets)
													->with('addresses', $addresses);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function postCheckout()
	{
		return $this->layout;
	}
}