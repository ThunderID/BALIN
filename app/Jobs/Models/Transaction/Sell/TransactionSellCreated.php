<?php

namespace App\Jobs\Models\Transaction\Sell;

use App\Jobs\Job;
use App\Jobs\ChangeStatus;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class TransactionSellCreated extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        //need to check user active or not
        $result                             = $this->dispatch(new ChangeStatus($this->transaction, 'cart'));

        return $result;
    }
}
