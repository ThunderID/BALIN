<?php namespace App\Http\Controllers;

use App\Http\Controllers\baseController;
use App\Models\user;
use App\Models\Transaction;
use App\Models\pointlog;
use App\Jobs\SendActivationEmail;
use App\Jobs\sendBillingEmail;
use App\Jobs\SendTransactionValidatedEmail;
use App\Jobs\RefreshCart;
use App\Jobs\sendShipmentEmail;
use Mail;

class testController extends baseController 
{
	protected $controller_name 					= 'test';

	public function testEmail()
	{	
		$data 									= 	[
														'name' 		=> 'budi',
														'activation_link' => 'aaaa'
													];

		$this->layout->page 					= view('emails.activation')
													->with('data',$data);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function error()
	{		
		$this->layout->page 					= view('pages.error')
													->with('controller_name', $this->controller_name);
		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function testLab()
	{		
		$input = Transaction::find(1);
		// dd($input->save());
		$result = $this->dispatch(new RefreshCart($input));

		dd($result);

		// exit;
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