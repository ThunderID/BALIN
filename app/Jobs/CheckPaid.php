<?php

namespace App\Jobs;

// check is paid
use App\Jobs\Job;

use App\Models\Payment;
use App\Models\Transaction;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

class CheckPaid extends Job implements SelfHandling
{
    protected $transaction;
    protected $payment;

    public function __construct(Transaction $transaction, Payment $payment)
    {
        $this->transaction                  = $transaction;
        $this->payment                      = $payment;
    }

    public function handle()
    {
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        if(is_null($this->payment->amount))
        {
            $total_paid                     = 0;
        }
        else
        {
            $total_paid                     = $this->payment->amount;
        }

        if($this->transaction->payment)
        {
            $total_paid                     = $total_paid + $this->transaction->payment->amount; 
        }

        if($total_paid == $this->transaction->amount)
        {
            $result                         = new JSend('success', (array)$this->transaction);
        }
        elseif($total_paid > $this->transaction->amount)
        {
            $result                         = new JSend('error', (array)$this->transaction, "Pembayaran berlebih sebesar ".($total_paid - $this->transaction->amount). '. Harap melakukan <a href="'.route('backend.data.payment.create').'"> validasi pembayaran </a> terlebih dahulu. ');
        }
        elseif($total_paid < $this->transaction->amount)
        {
            $result                         = new JSend('error', (array)$this->transaction, "Pembayaran kurang sebesar ".($this->transaction->amount - $total_paid). '. Harap melakukan <a href="'.route('backend.data.payment.create').'"> validasi pembayaran </a> terlebih dahulu. ');
        }
        
        return $result;
    }
}
