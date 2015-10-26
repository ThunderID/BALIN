<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Transaction;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag as MessageBag;

use App\Libraries\JSend;

class GeneratePaymentEmail extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction           = $transaction;
    }

    public function handle()
    {
        // checking
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //get payments
        $payments                   = $this->transaction->payments;

        $errors                     = new MessageBag;

        if(is_null($payments))
        {
            $errors->add($this->transaction->user->name, 'Pesanan '.$this->transaction->user->name.' belum dibayar'); 
        }

        if($errors->count()) 
        {
            $result                 = new JSend('error', (array)$this->transaction, (array)$errors);
        }
        else
        {
            $result                 = new JSend('success', (array)$this->transaction);
        }

        return $result;    
    }
}
