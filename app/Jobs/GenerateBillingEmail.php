<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag as MessageBag;

use App\Libraries\JSend;

class GenerateBillingEmail extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction           = $transaction;
    }

    public function handle()
    {
        $errors                     = new MessageBag;

        // checking
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

         //get products
        $transaction                = transaction::find($transaction)
                                        ->with(array('TransactionDetail'=>function($query){
                                                $query->with('product');
                                            }))
                                        ->get();

        if(is_null($products))
        {
            $errors->add($this->transaction->user->name, 'Tidak ada barang untuk transaksi '.$this->transaction->user->name); 
        }

        if(empty($product)) 
        {
            $result                 = new Jsend('error', (array)$this->transaction, (array)$errors);
        }
        else
        {
            $result                 = new Jsend('success', (array)$transaction);
        }

        return $result; 

    }
}
