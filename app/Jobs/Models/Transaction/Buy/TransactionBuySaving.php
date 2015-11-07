<?php

namespace App\Jobs\Models\Transaction\Buy;

use App\Jobs\Job;
use App\Jobs\GenerateTransactionDate;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class TransactionBuySaving extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->transaction);
    }
}
