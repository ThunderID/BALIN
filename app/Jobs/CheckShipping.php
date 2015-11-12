<?php

namespace App\Jobs;

// check is paid
use App\Jobs\Job;

use App\Models\Transaction;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

class CheckShipping extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        if(is_null($this->transaction->shipment->receipt_number) || $this->transaction->shipment->receipt_number='')
        {
            $result                         = new JSend('error', (array)$this->transaction, 'Nomor resi pengiriman belum ada. Tambahkan nomor resi pengiriman <a href="'.route('backend.data.shipment.edit', $this->transaction->shipment->id).'"> disini </a>.');
        }
        else
        {
            $result                         = new JSend('success', (array)$this->transaction);
        }

        return $result;
    }
}
