<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Jobs\Mailman;
use App\Jobs\GenerateBillingEmail;
use App\Models\Transaction;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class SendBillingEmail extends Job implements SelfHandling
{
    protected $transaction;

	public function __construct(transaction $transaction)
	{
	    $this->transaction				= $transaction;
	}

	public function handle(Mailer $mail)
	{
	    // checking
	    if(is_null($this->transaction->id))
	    {
	        throw new Exception('Sent variable must be object of a record.');
	    }
	    
	    //get Billing
		$datas 								= $this->dispatch(new GenerateBillingEmail($this->transaction));        

        //send email
        $mail_data      = [
                            'view'          => 'emails.test', 
                            'datas'         => (array)$datas, 
                            'dest_email'    => 'budi-purnomo@outlook.com', 
                            'dest_name'     => 'budi purnomo', 
                            'subject'       => 'Billing Information', 
                        ];

        // call email send job
        $this->dispatch(new Mailman($mail_data));

        return true;
	}

	public function getBill()
	{
	    // call job get bill
	    return "a";
	}
}
