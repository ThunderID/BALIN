<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Shipment;

class ShipmentUpdated extends Job implements SelfHandling
{
    protected $shipment;

    public function __construct()
    {
        $this->shipment             = $shipment;
    }

    public function handle()
    {
        return new jsend('success', (array)$this->shipment);
    }
}
