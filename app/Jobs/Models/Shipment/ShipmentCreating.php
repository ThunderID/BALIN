<?php

namespace App\Jobs\Models\Shipment;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Shipment;

class ShipmentCreating extends Job implements SelfHandling
{
    protected $shipment;

    public function __construct(Shipment $shipment)
    {
        $this->shipment             = $shipment;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->shipment);
    }
}
