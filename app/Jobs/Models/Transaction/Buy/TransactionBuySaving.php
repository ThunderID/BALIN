<?php

namespace App\Jobs\Models\Transaction\Buy;

use App\Jobs\Job;
use App\Jobs\GenerateTransactionRefNumber;
use App\Jobs\CountReferralDiscount;
use App\Jobs\FillTransactionDate;
use App\Jobs\GenerateTransactionUniqNumber;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class TransactionBuySaving extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        //need to check user active or not
        $result                         = new JSend('success', (array)$this->transaction );

        return $result;
    }
}
