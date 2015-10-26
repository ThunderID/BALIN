<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Policy;

use App\Libraries\JSend;


class CountReferralDiscount extends Job implements SelfHandling
{

    Protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction              = $transaction;
    }

    public function handle()
    {
        $product_prices                 = TransactionDetail::transactionid($this->transaction->id)
                                                ->selectraw('(price - discount) * quantity as total')
                                                ->first()
                                                ;

        $disc                           = Policy::type('referral_discount')->first();

        $referral_discount              = ($product_prices['total'] * $disc['value'])/100;

        if(empty($this->transaction->referral_discount))
        {
            $this->transaction->fill([
                'referral_discount'     => $referral_discount,
            ]);

            if(!$this->transaction->save())
            {
                return new JSend('error', (array)$this->transaction->geterror(), (array)$this->transaction);
            }
        }

        return new JSend('success', (array)$this->transaction);
    }
}
