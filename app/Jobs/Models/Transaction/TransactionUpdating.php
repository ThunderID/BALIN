<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class TransactionUpdating extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }
    
    public function handle()
    {
        $result                          = new jsend('success', (array)$this->transaction );
    }
}
