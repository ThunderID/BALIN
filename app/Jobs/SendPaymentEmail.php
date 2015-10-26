<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Transaction;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Libraries\JSend;

class SendPaymentEmail extends Job implements SelfHandling
{
    use DispatchesJobs;
    
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction             = $transaction;
    }

    public function handle()
    {
        // checking
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }
        
        //get Payment
        $datas                              = $this->dispatch(new GeneratePaymentEmail($this->transaction));        


        //send email
        $mail_data      = [
                            'view'          => 'emails.test', 
                            'datas'         => (array)$datas, 
                            'dest_email'    => $this->transaction->user->email, 
                            'dest_name'     => $this->transaction->user->name, 
                            'subject'       => 'Payment Validation Information', 
                        ];

        // call email send job
        $this->dispatch(new Mailman($mail_data));

        return new JSend('success', (array)$this->transaction);           
    } 
}
