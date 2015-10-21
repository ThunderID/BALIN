<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\models\transaction;
use App\models\transactionDetail;
use App\models\Policy;

use App\Libraries\JSend;


class CountReferralDiscount extends Job implements SelfHandling
{

    Protected $transaction;

    public function __construct(transaction $transaction)
    {
        $this->transaction              = $transaction;
    }

    public function handle()
    {
        $product_prices                 = transactiondetail::where('transaction_id', $this->transaction->id)
                                                ->selectraw('(price - discount) * quantity as total')
                                                ->first()
                                                ;

        $disc                           = policy::type('referral_discount')->first();

        $referral_discount              = ($product_prices['total'] * $disc['value'])/100;

        if(empty($this->transaction->referral_discount))
        {
            $this->transaction->fill([
                'referral_discount'     => $referral_discount,
            ]);

            if(!$this->transaction->save())
            {
                return new jsend('error', (array)$this->transaction->geterror(), (array)$this->transaction);
            }
        }

        return new jsend('success', (array)$this->transaction);
    }
}
