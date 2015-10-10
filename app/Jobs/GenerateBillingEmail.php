<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\transaction;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag as MessageBag;

use App\Libraries\JSend;

class GenerateBillingEmail extends Job implements SelfHandling
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

         //get products
        $products                   = $this->transaction->products;

        if(is_null($products))
        {
            $errors->add($this->transaction->user->name, 'Tidak ada barang untuk transaksi '.$this->transaction->user->name); 
        }

        if($errors->count()) 
        {
            $result                 = new Jsend('error', (array)$this->transaction, (array)$errors);
        }
        else
        {
            $result                 = new Jsend('success', (array)$this->products);
        }

        $errors                     = new MessageBag;

    }
}
