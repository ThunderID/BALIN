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
        $transaction                = Transaction::id($this->transaction->id)->with(['transactiondetails', 'transactiondetails.product'])->first();

        if(is_null($transaction))
        {
            $errors->add($this->transaction->user->name, 'Tidak ada barang untuk transaksi '.$this->transaction->user->name); 
        }

        if(empty($transaction)) 
        {
            $result                 = new JSend('error', (array)$this->transaction, (array)$errors);
        }
        else
        {
            $result                 = new JSend('success', (array)$transaction);
        }

        return $result; 

    }
}
