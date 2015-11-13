<?php

namespace App\Jobs\Models\Transaction\Sell;

use App\Jobs\Job;
use App\Jobs\CreditQuota;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

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

        if($this->transaction->voucher->count())
        {
            $result                             = $this->dispatch(new CreditQuota($this->transaction->voucher, 'Penggunaan voucher untuk transaksi #'.$this->transaction->ref_number));
        }

        return $result;
    }
}
