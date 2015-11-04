<?php

namespace App\Jobs\Models\Shipment;

use App\Jobs\Job;
use App\Jobs\SendShipmentEmail;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Shipment;
use App\Models\Transaction;
use App\Libraries\JSend;

class ShipmentSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $shipment;

    public function __construct(Shipment $shipment)
    {
        $this->shipment                 = $shipment;
    }

    public function handle()
    {
        $result                         = new JSend('success', (array)$this->shipment);

        return $result;
    }
}
