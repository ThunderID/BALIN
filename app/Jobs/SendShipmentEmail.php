<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\transaction;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Bus\SelfHandling;

class SendShipmentEmail extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(transaction $transaction)
    {
        $this->transaction 					= $transaction;
    }

    public function handle(Mailer $mail)
    {
        // checking
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //get shipment
        // call job get shipment

        //send email
        $mail_data      = [
                            'view'          => 'emails.test', 
                            'datas'         => 'nn', 
                            'dest_email'    => 'budi-purnomo@outlook.com', 
                            'dest_name'     => 'budi purnomo', 
                            'subject'       => 'Shipping Information', 
                        ];

        // call email send job
        
        return true;
    }
}
