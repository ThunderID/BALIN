<?php

namespace App\Jobs\Models\Transaction\Buy;

use App\Jobs\Job;
use App\Jobs\ChangeStatus;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;
use App\Libraries\JSend;

class TransactionBuyCreated extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        //save transaction log
        $result                             = $this->dispatch(new ChangeStatus($this->transaction, 'delivered', 'stock'));

        return $result;
    }
}
