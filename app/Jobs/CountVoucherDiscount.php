<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\Transaction;

use App\Libraries\JSend;

class CountVoucherDiscount extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        $result                             = new JSend('success', (array)$this->transaction);
        if($this->transaction->voucher)
        {
            switch($this->transaction->voucher->type)
            {
                case 'free_shipping_cost' :
                    $this->transaction->voucher_discount    = $this->transaction->shipping_cost;
                break;
                case 'debit_point' :
                    $result                                 = $this->dispatch(new DebitPoint($this->transaction, $this->transaction->voucher->value));
                break;
                default :
                break;
            }
        }

        return $result;
    }
}
