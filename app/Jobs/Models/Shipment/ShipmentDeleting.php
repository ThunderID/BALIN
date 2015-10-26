<?php

namespace App\Jobs\Models\Shipment;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Shipment;

class ShipmentDeleting extends Job implements SelfHandling
{
    protected $shipment;

    public function __construct(Shipment $shipment)
    {
        $this->shipment             = $shipment;
    }

    public function handle()
    {
    	if($this->shipment->receipt_number)
    	{
    		return new JSend('error', (array)$this->shipment, 'Tidak dapat menghapus data barang yang telah dikirm');
    	}

        return new JSend('success', (array)$this->shipment);
    }
}
