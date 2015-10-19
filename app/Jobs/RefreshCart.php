<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

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

        $details                           = transactionDetail::where('transaction_id', 1)->get();

        foreach ($details as $detail) 
        {
            $product                       = Product::find($detail->product_id);

            $detail->fill([
                'price'                    => $product->price,
                'discount'                 => $product->discount,
            ]);

            $detail->save();

        }
        dd(1);
    }
}
