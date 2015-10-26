<?php

namespace App\Jobs;

/*
    Input   : Instance of transaction with transaction ID (exists transaction)
    Process : Count total paid is it from bank transfer or pointlogs (only true if amount and paid were same value)
    Output  : JSEND format, if errors will displayed errors with error message, if success return transaction model
*/

use App\Jobs\Job;

use App\Models\Transaction;

use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use Exception;

class ReferralPointIsGiven extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        //
        $this->transaction          = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

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
                if($voucher->user_id==$transaction->user_id)
                {
                    return new JSend('error', (array)$this->transaction, 'Tidak dapat memakai referral code anda');
                }

                $policy                 = Policy::type('referral_royalty')->first();

                $debit                   = ($policy->value * $this->transaction->amount)/100;

                $ptrs                   = PointLog::transactionid($this->transaction->id)->first();

                $result                 = $this->dispatch(new CountPointExpirationDate($this->transaction->user));

                if($result->getStatus()=='success')
                {
                    if($ptrs)
                    {
                        $point          = $ptrs;
                    }
                    else
                    {
                        $point          = new PointLog;
                    }

                    $point->fill([
                        'transaction_id'=> $this->transaction->id,
                        'user_id'       => $voucher->user_id,
                        'debit'         => $debit,
                        'expired_date'  => $result->getData()['expired_date'],
                        'notes'         => 'Referral code for transaction #'.$this->transaction->ref_number,

                    ]);

                    if($point->save())
                    {
                        $result         = new JSend('success', (array)$this->transaction);
                    }
                    else
                    {
                        $result         = new JSend('error', (array)$this->transaction, $point->getError());
                    }
                }
            }
            
            return $result;
        }
        else
        {
            return new JSend('success', (array)$this->transaction);
        }
    }
}
