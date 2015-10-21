<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;


class TransactionSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct(Transaction $transaction)
    {
        $this->transaction          = $transaction;
    }

    public function handle()
    {
        $result                     = $this->dispatch(new SwitchTransaction($this->transaction));

        return $result;
    }
}
