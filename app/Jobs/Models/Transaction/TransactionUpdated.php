<?php

namespace App\Jobs\Models\Transaction;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class TransactionUpdated extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }
    
    public function handle()
    {
        $result                          	= new JSend('success', (array)$this->transaction );
        
        return $result;
    }
}
