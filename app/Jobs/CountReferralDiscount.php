<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Policy;
use App\Models\Voucher;

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
        if(!is_null($this->transaction->referral_code))
        {

            $voucher                    = Voucher::code($this->transaction->referral_code)->first();
            //if there is no voucher
            if(is_null($voucher))
            {
                return new JSend('error', (array)$this->transaction, 'Nomor kupon tidak valid');
            }

            //if there is referral code
            if($voucher->type=='referral')
            {
                if($voucher->user_id==$this->transaction->user_id)
                {
                    return new JSend('error', (array)$this->transaction, 'Tidak dapat memakai referral code anda');
                }

                $policy                 = Policy::type('referral_discount')->first();

                $subtotal               = TransactionDetail::transactionid($this->transaction->id)
                                                ->selectraw('(price - discount) * quantity as total')
                                                ->first()
                                            ;
                                            
                $disc                   = ($subtotal['total'] * $policy['value'])/100;

                //give point for referral owner
            }
            elseif($voucher->type=='shipping')
            {
                //call job shipping
                $disc                   = $this->transaction->shipping_cost;
            }

            if(!isset($disc) && is_null($disc))
            {
                return new JSend('error', (array)$this->transaction, 'Tidak ada diskon');
            }

            $this->transaction->referral_discount       = $disc;
        }

        return new JSend('success', (array)$this->transaction);
    }
}
