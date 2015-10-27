<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Transaction;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Libraries\JSend;


class SendBillingEmail extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $transaction;

	public function __construct(Transaction $transaction)
	{
	    $this->transaction				= $transaction;
	}

	public function handle()
	{
		try
		{
		    // checking
		    if(is_null($this->transaction->id))
		    {
		        throw new Exception('Sent variable must be object of a record.');
		    }
		    
		    //get Billing
			$datas 								= $this->dispatch(new GenerateBillingEmail($this->transaction));        

			if($datas->getStatus() != 'success')
			{
		        return $datas;           
			}
			else
			{
		        //send email
		        $name 			=  $this->transaction->user->name;
		        $mail_data      = [
		                            'view'          => 'emails.test', 
		                            'datas'         => 	[
		                            						'name'	=> $name,
		                            						'products' => (array)$datas->getData(),
		                            						'transaction'	=> $this->transaction,
		                            					],
		                            'dest_email'    => $this->transaction->user->email, 
		                            'dest_name'     => $name, 
		                            'subject'       => 'Billing Information', 
		                        ];

		        // call email send job
		        $this->dispatch(new Mailman($mail_data));
		        
		        return new JSend('success', (array)$this->transaction)  ;           
			}
		}
		catch (Exception $e) 
		{
		    $this->release(10);
		}		
	}	
}
