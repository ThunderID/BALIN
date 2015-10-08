<?php

namespace App\Jobs;

/*
    Input   : Instance of transaction with transaction ID (exists transaction)
    Process : Check current stock and on hold stock in based on transactions' products quantity
    Output  : JSEND format, if errors will displayed errors with error message, if success return transaction model
*/
use App\Jobs\Job;

use Illuminate\Contracts\Bus\SelfHandling;
use \Illuminate\Support\MessageBag as MessageBag;

use App\Models\Transaction;

use App\Libraries\JSend;

use Exception;

class StockIsChecking extends Job implements SelfHandling
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
            $current                = $physical->bought_stock - $onhold->on_hold_stock - $reserved->reserved_stock;


            if($current < 0)
            {
                $errors->add($value->product->name, 'Stock '.$value->product->name.' tidak mencukupi.'); 
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
