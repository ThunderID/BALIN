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
        if($this->transaction->voucher && $this->transaction->status=='paid')
        {
            switch($this->transaction->voucher->type)
            {
                case 'debit_point' :
                    $result                                 = $this->dispatch(new DebitPoint($this->transaction, $this->transaction->voucher->value));
                break;
                default :
                break;
            }
        }
        elseif($this->transaction->voucher)
        {
            switch($this->transaction->voucher->type)
            {
                case 'free_shipping_cost' :
                    $this->transaction->voucher_discount    = (!is_null($this->transaction->shipping_cost) ? $this->transaction->shipping_cost : 0);
                break;
                default :
                break;
            }
        }

        return $result;
    }
}
