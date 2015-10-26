<?php

namespace App\Jobs;

/*
    Input   : Instance of transaction with transaction ID (exists transaction)
    Process : Count total paid is it from bank transfer or pointlogs (only true if amount and paid were same value)
    Output  : JSEND format, if errors will displayed errors with error message, if success return transaction model
*/

use App\Jobs\Job;

use App\Models\Transaction;
use App\Models\Payment;

use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use Exception;

class PaymentIsValid extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, Payment $payment)
    {
        //
        $this->transaction          = $transaction;
        $this->payment              = $payment;
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

        if($payments)
        {
            foreach ($payments as $key => $value) 
            {
                $paid               = $paid + $value->amount;
            }
        }

        if($this->payment)
        {
            $paid                   = $paid + $this->payment->amount;
        }

         if($points)
        {
            foreach ($points as $key => $value) 
            {
                $paid               = $paid + $value->credit - $value->debit ;
            }
        }
       
        $achieved                   = $paid - $amount;

        if($achieved == 0)
        {
            $this->transaction->fill(['status' => 'paid']);
            
            if($this->transaction->save())
            {
                $result             = new JSend('success', (array)$this->transaction);
            }
            else
            {
                $result             = new JSend('error', (array)$this->transaction->getError());
            }
        }
        elseif($achieved > 0)
        {
            $result                 = new JSend('error', (array)$this->transaction, 'Pembayaran berlebih, sebesar '.$achieved);
        }
        else
        {
            $result                 = new JSend('error', (array)$this->transaction, 'Pembayaran kurang, sebesar '.abs($achieved));
        }

        return $result;
    }
}
