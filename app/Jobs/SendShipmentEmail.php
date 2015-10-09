<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Jobs\Mailman;
use App\Jobs\GenerateShipmentEmail;
use App\Models\Transaction;
use Illuminate\Contracts\Bus\SelfHandling;

class SendShipmentEmail extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction 					= $transaction;
    }

    public function handle()
    {
        // checking
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //get shipment
        // call job get shipment
		$datas 								= $this->dispatch(new GenerateShipmentEmail($this->transaction));        

        //send email
        $mail_data      = [
                            'view'          => 'emails.test', 
                            'datas'         => '$datas', 
                            'dest_email'    => 'budi-purnomo@outlook.com', 
                            'dest_name'     => 'budi purnomo', 
                            'subject'       => 'Shipping Information', 
                        ];

        // call email send job
        $this->dispatch(new Mailman($mail_data));

        return true;
    }
}
