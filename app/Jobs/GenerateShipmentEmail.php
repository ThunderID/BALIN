<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Transaction;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag as MessageBag;

use App\Libraries\JSend;

class GenerateShipmentEmail extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction           = $transaction;
    }

    public function handle()
    {
        // checking
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //get shipment
        $shipment                   = $this->transaction->shipment;

        $errors                     = new MessageBag;

        if(is_null($shipment))
        {
            $errors->add($this->transaction->user->name, 'Pesanan '.$this->transaction->user->name.' belum memiliki nomor resi'); 
        }
        elseif(is_null($shipment->receipt_number))
        {
            $errors->add($shipment->transaction->user->name, 'Pesanan '.$shipment->transaction->user->name.' belum memiliki nomor resi'); 
        }

        if($errors->count()) 
        {
            $result                 = new JSend('error', (array)$this->transaction, (array)$errors);
        }
        else
        {
            $result                 = new JSend('success', (array)$this->shipment);
        }

        return $result;        
    }
}
