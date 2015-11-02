<?php

namespace App\Jobs\Models\Transaction\Sell;

use App\Jobs\Job;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

use App\Jobs\SendBillingEmail;
use App\Jobs\StockRecalculate;
use App\Jobs\GenerateRefferalCode;
use App\Jobs\SendReferralCodeEmail;
use App\Jobs\RevertUserPoints;

class TransactionSellSaved extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                      = $transaction;
    }

    public function handle()
    {
        $result                                 = new JSend('success', (array)$this->transaction );

        return $result;
    }
}
