<?php

namespace App\Jobs;

// check all quantity
use App\Jobs\Job;

use App\Models\Transaction;
use App\Models\PointLog;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

class CheckStock extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        foreach ($this->transaction->transactiondetails as $key => $value) 
        {
            if($value->quantity > $value->product->stock)
            {
                return new JSend('error', (array)$this->transaction, "Stok ".$value->product->name." tinggal ".$value->product->stock);
            }
        }

        $result                             = new JSend('success', (array)$this->transaction);
        
        return $result;
    }
}
