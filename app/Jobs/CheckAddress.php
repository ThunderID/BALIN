<?php

namespace App\Jobs;

// check is paid
use App\Jobs\Job;

use App\Models\Transaction;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

class CheckAddress extends Job implements SelfHandling
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

        if(is_null($this->transaction->shipment))
        {
            $result                         = new JSend('error', (array)$this->transaction, 'Belum ada alamat pengiriman.');
        }
        else
        {
            $result                         = new JSend('success', (array)$this->transaction);
        }

        return $result;
    }
}
