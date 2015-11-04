<?php

namespace App\Jobs\Models\Transaction\Sell;

use App\Jobs\Job;
use App\Jobs\CountVoucherDiscount;
use App\Jobs\GenerateTransactionDate;
use App\Jobs\GenerateTransactionRefNumber;
use App\Jobs\GenerateTransactionUniqNumber;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class TransactionSellSaving extends Job implements SelfHandling
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
        $result                             = new JSend('success', (array)$this->transaction);
        if($this->transaction->status=='cart' || $this->transaction->status=='na')
        {
            $result                         = $this->dispatch(new GenerateTransactionRefNumber($this->transaction));

            if($result->getStatus()=='success')
            {
                $result                     = $this->dispatch(new GenerateTransactionDate($this->transaction));
            }

            if($result->getStatus()=='success')
            {
                $result                     = $this->dispatch(new GenerateTransactionUniqNumber($this->transaction));
            }
        }
        if($result->getStatus()=='success')
        {
            $result                         = $this->dispatch(new CountVoucherDiscount($this->transaction));
        }

        return $result;
    }
}
