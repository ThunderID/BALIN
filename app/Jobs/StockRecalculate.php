<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Transaction;
use Illuminate\Contracts\Bus\SelfHandling;

class StockRecalculate extends Job implements SelfHandling
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
        $details                    = $transaction->transactiondetails;

        foreach ($details as $key => $value) 
        {
            $onhold                 = Product::id($value->product_id)->countOnHoldStock(true);
            $reserved               = Product::id($value->product_id)->countReservedStock(true);
            $physical               = Product::id($value->product_id)->CountBoughtStock(true);
            $current                = $physical->bought_stock - $onhold->on_hold_stock - $reserved->reserved_stock;

            $stock                  = new Stock;

            $stock->fill([
                    'product_id'                    => $value->product_id,
                    'transaction_detail_id'         => $value->id,
                    'ondate'                        => date('Y-m-d', strtotime($value->updated_at)),
                    'current_stocks'                => $current,
                    'on_hold_stocks'                => $onhold->on_hold_stock,
                    'reserved_stocks'               => $reserved->reserved_stock,
                ]);

            if($stock->Save())
            {
                return true;
            }

            return false;
        }

    }
}
