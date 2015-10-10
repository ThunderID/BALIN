<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\transaction;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag as MessageBag;

use App\Libraries\JSend;

class GenerateTransactionValidatedEmail extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(transaction $transaction)
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
        elseif(is_null($payments->receipt_number))
        {
            $errors->add($payments->transaction->user->name, 'Pesanan '.$payments->transaction->user->name.' belum dibayar'); 
        }

        if($errors->count()) 
        {
            $result                 = new Jsend('error', (array)$this->transaction, (array)$errors);
        }
        else
        {
            $result                 = new Jsend('success', (array)$this->payments);
        }

        return $result;    
    }
}
