<?php

namespace App\Jobs;

use App\Jobs\Job;

use App\Models\Transaction;
use App\Models\TransactionDetail;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

class CalculateTransactionAmount extends Job implements SelfHandling
{
    
    Protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $product_prices                     = TransactionDetail::where('transaction_id', $this->transaction->id)
                                                ->selectraw('(price - discount) * quantity as total')
                                                ->first()
                                                ;

        $amount                             = ($this->transaction->shipping_cost + $product_prices['total']) - ($this->transaction->unique_number + $this->transaction->referral_discount);

        $this->transaction->fill([
            'amount'         => $amount,
        ]);


        if($this->transaction->save())
        {
            $result                         = new JSend('success', (array)$this->transaction);
        }
        else
        {
            $result                         = new JSend('error', (array)$this->transaction, (array)$this->transaction->getError());
        }
        return $result;
    }
}
