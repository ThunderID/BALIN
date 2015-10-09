<?php

namespace App\Jobs;

/*
    Input   : Instance of transaction with transaction ID (exists transaction)
    Process : Count Reserved stock, current stock and on hold stock in based on transactions' products quantity + saved stock
    Output  : JSEND format, if errors will displayed errors with error message, if success return transaction model
*/

use App\Jobs\Job;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Stock;

use Illuminate\Contracts\Bus\SelfHandling;
use \Illuminate\Support\MessageBag as MessageBag;

use App\Libraries\JSend;

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
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $details                    = $this->transaction->transactiondetails;

        $errors                     = new MessageBag;

        foreach ($details as $key => $value) 
        {
            $onhold                 = Product::id($value->product_id)->countOnHoldStock(true);
            $reserved               = Product::id($value->product_id)->countReservedStock(true);
            $physical               = Product::id($value->product_id)->CountBoughtStock(true);
            $current                = 0;

            if($physical)
            {
                $current            = $current + $physical->bought_stock;
            }

            if(isset($onhold->on_hold_stock))
            {
                $current            = $current - $onhold->on_hold_stock;
                $onholdstock        = $onhold->on_hold_stock;
            }
            else
            {
                $onholdstock        = 0;
            }

            if(isset($reserved->reserved_stock))
            {
                $current            = $current - $reserved->reserved_stock;
                $reservedstock      = $reserved->reserved_stock;
            }
            else
            {
                $reservedstock      = 0;
            }

            $stock                  = new Stock;

            $stock->fill([
                    'product_id'                    => $value->product_id,
                    'transaction_detail_id'         => $value->id,
                    'ondate'                        => date('Y-m-d', strtotime($value->updated_at)),
                    'current_stocks'                => $current,
                    'on_hold_stocks'                => $onholdstock,
                    'reserved_stocks'               => $reservedstock,
                ]);

            if(!$stock->Save())
            {
                $errors->add($value->product->name, $stock->getError()); 
            }

        }

        if($errors->count())
        {
            $result                 = new Jsend('error', (array)$this->transaction, (array)$errors);
        }
        else
        {
            $result                 = new Jsend('success', (array)$this->transaction);
        }

        return $result;
    }
}