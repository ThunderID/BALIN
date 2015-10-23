<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Shipment;

class ShipmentDeleting extends Job implements SelfHandling
{
    protected $shipment;

    public function __construct()
    {
        $this->shipment             = $shipment;
    }

    public function handle()
    {
    	if($this->shipment->receipt_number)
    	{
    		return new jsend('error', (array)$this->shipment, ['message' => 'Tidak dapat menghapus data barang yang telah dikirm']);
    	}

        return new jsend('success', (array)$this->shipment);
    }
}
