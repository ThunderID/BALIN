<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\user;
use App\Models\transaction;
use App\Jobs\SendActivationEmail;
use App\Jobs\sendBillingEmail;
use App\Jobs\SendTransactionValidatedEmail;
use App\Jobs\TransactionIsExpired;
use App\Jobs\sendShipmentEmail;
use Mail;

class testController extends Controller 
{
	protected $controller_name 					= 'test';

	public function error()
	{		
		$this->layout->page 					= view('pages.error')
													->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function testLab()
	{		
		$transaction = transaction::find(1);
		$this->dispatch(new TransactionIsExpired($transaction));

		exit;
	}	

	public function SendActivationEmail()
	{
		$user= User::find(1);
		$this->dispatch(new SendActivationEmail($user));

		exit;
	}

	public function sendBillingEmail()
	{
		$user= User::find(1);
		$this->dispatch(new sendBillingEmail($user));

		exit;	
	}

	public function sendTransactionValidatedEmail()
	{
		$user= User::find(1);
		$this->dispatch(new SendTransactionValidatedEmail($user));

		exit;	
	}	

	public function sendShipmentEmail()
	{
		$user= User::find(1);
		$this->dispatch(new SendShipmentEmail($user));

		exit;	
	}	
}