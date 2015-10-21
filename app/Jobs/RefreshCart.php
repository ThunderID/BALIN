<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\models\product;
use App\models\transaction;
use App\models\transactionDetail;

class RefreshCart extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(transaction $transaction)
    {
        $this->transaction                 = $transaction;
    }

    public function handle()
    {
        // checking
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $details                           = transactionDetail::where('transaction_id', $this->transaction->id)->get();

        if($this->transaction->status == 'draft')
        {
            foreach ($details as $detail) 
            {
                $product                   = Product::find($detail->product_id);

                $detail->fill([
                    'price'                => $product->price,
                    'discount'             => $product->discount,
                ]);

                if(!$detail->save())
                {
                    return new Jsend('error', (array)$this->user, (array)$transaction);
                }
            }
        }

        return new Jsend('success', (array)$this->transaction);
    }
}
