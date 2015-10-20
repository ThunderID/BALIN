<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class generateTransactionUniqNumber extends Job implements SelfHandling
{
    protected $transaction; 

    public function __construct(transaction $transaction)
    {
        $this->transaction              = $transaction;
    }


    public function handle()
    {
        try
        {
            if(is_null($this->transaction->id))
            {
                throw new Exception('Sent variable must be object of a record.');
            }

            if(!empty($this->transaction->unique_number))
            {
                $this->transaction->unique_number    = 3333;
            }

            $result                     = new Jsend('success', ['message' => 'Expired date added']);
        } 
        catch (Exception $e) 
        {
            $result                     = new Jsend('fail', (array)$e);
        }  

        return $result;
    }
}
