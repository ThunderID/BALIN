<?php

namespace App\Jobs\Models\TransactionDetail\Buy;

use App\Jobs\Job;
use App\Jobs\CountReferralDiscount;
use App\Jobs\CalculateTransactionAmount;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionDetailBuySaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $transactiondetail;

    public function __construct(TransactionDetail $transactiondetail)
    {
        $this->transactiondetail            = $transactiondetail;
    }

    public function handle()
    {
        $result                     = $this->dispatch(new CalculateTransactionAmount($this->transactiondetail->transaction));
         
        return $result;
    }    
}
