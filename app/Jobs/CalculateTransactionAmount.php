<?php

namespace App\Jobs;

use App\Jobs\Job;

use App\Models\transaction;
use App\Models\transactiondetail;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

class CalculateTransactionAmount extends Job implements SelfHandling
{
    
    Protected $transaction;

    public function __construct(transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $product_prices                     = transactiondetail::where('transaction_id', $this->transaction->id)
                                                ->selectraw('(price - discount) * quantity as total')
                                                ->first()
                                                ;

        $amount                             = ($this->transaction->shipping_cost + $product_prices['total']) - ($this->transaction->uniq_number + $this->transaction->shipping_cost);

        $this->transaction->fill([
            'amount'         => $amount,
        ]);

        if($this->transaction->save())
        {
            $result                         = new Jsend('success', (array)$this->transaction);
        }
        else
        {
            $result                         = new Jsend('error', (array)$this->transaction->getError() ,(array)$this->transaction);
        }
        return $result;
    }
}
