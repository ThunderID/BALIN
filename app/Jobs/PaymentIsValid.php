<?php

namespace App\Jobs;

/*
    Input   : Instance of transaction with transaction ID (exists transaction)
    Process : Count total paid is it from bank transfer or pointlogs (only true if amount and paid were same value)
    Output  : JSEND format, if errors will displayed errors with error message, if success return transaction model
*/

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class PaymentIsValid extends Job implements SelfHandling
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

        $payments                   = $this->transaction->payments;
        $points                     = $this->transaction->points;

        $amount                     = $this->transaction->amount;
        $paid                       = 0;

        foreach ($payments as $key => $value) 
        {
            $paid                   = $paid + $value->amount;
        }

        foreach ($points as $key => $value) 
        {
            $paid                   = $paid + $value->credit - $value->debit ;
        }

        $achieved                   = $paid - $amount;
        if($achieved = 0)
        {
            $result                 = new Jsend('success', (array)$this->transaction);
        }
        elseif($achieved > 0)
        {
            $result                 = new Jsend('error', (array)$this->transaction, ['more' => 'Pembayaran berlebih, sebesar '.$achieved]);
        }
        else
        {
            $result                 = new Jsend('error', (array)$this->transaction, ['more' => 'Pembayaran kurang, sebesar '.(0 - $achieved)]);
        }

        return $result;
    }
}
