<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\transaction;

class TransactionCreated extends Job implements SelfHandling
{
    protected $transaction; 

    public function __construct(transaction $transaction)
    {
        $this->transaction               = $transaction;
    }

    public function handle()
    {
        $result                          = new jsend('success', (array)'Sukses' );

        return $result;
    }
}
