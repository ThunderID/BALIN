<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Payment;
use App\Models\Transaction;

class ValidatePayment extends Job implements SelfHandling
{
    $protected Payment;

    public function __construct(payment $payment)
    {
        $this->payment              = $payment;
    }

    public function handle()
    {
        if(is_null($this->payment->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $transaction                = transaction::find($this->payment->transaction_id);

        if(empty($transaction))
        {
            return new jsend('error', (array)$payment , ['message' => 'Transaksi tidak ditemukan']);
        }

        $this->payment->fill([
            'transaction_id'        => $transaction['id'];
        ]);

        if(!$this->save())
        {
            return new jsend('error', (array)$payment, (array)$payment->getError() );
        }

        return new jsend('success', (array)$payment);
    }
}
