<?php

namespace App\Jobs\Models\Transaction\Buy;

use App\Jobs\Job;
use App\Jobs\GenerateTransactionRefNumber;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class TransactionBuyCreating extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        $result                             = $this->dispatch(new GenerateTransactionRefNumber($this->transaction));

        return $result;
    }
}
