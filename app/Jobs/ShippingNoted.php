<?php

namespace App\Jobs;

use App\Jobs\Job;

use App\Models\Transaction;

use Illuminate\Contracts\Bus\SelfHandling;
use \Illuminate\Support\MessageBag as MessageBag;

use Exception;

class ShippingNoted extends Job implements SelfHandling
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

        $errors                     = new MessageBag;

        $shipments                  = $this->transaction->shipments;
     
        foreach ($shipments as $key => $value) 
        {
            if(is_null($value->receipt_number))
            {
                $errors->add($value->user->name, 'Pesanan '.$value->user->name.' belum memiliki nomor resi'); 
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
