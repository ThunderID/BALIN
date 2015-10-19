<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\user;
use App\Models\Transaction;
use App\Models\pointlog;
use App\Jobs\SendActivationEmail;
use App\Jobs\sendBillingEmail;
use App\Jobs\SendTransactionValidatedEmail;
use App\Jobs\revertUserPoints;
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
		$input = Transaction::type('sell')->first();
		dd($input->save());
		// $result = $this->dispatch(new revertUserPoints($input));

		// dd($result);

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