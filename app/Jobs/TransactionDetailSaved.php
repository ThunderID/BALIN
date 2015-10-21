<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\transaction;
use App\Models\transactiondetail;

class TransactionDetailSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $transactiondetail;

    public function __construct(transactiondetail $transactiondetail)
    {
        $this->transactiondetail            = $transactiondetail;
    }

    public function handle()
    {
        $transaction                        = transaction::find($this->transactiondetail->transaction_id);
    
        $result                             = $this->dispatch(new countReferralDiscount($transaction));
        $result                             = $this->dispatch(new calculateTransactionAmount($transaction));

        return $result;
    }    
}
