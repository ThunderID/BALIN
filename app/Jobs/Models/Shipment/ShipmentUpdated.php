<?php

namespace App\Jobs\Models\Shipment;

use App\Jobs\Job;
use App\Jobs\ChangeStatus;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Shipment;

class ShipmentUpdated extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $shipment;

    public function __construct(Shipment $shipment)
    {
        $this->shipment						= $shipment;
    }

    public function handle()
    {
    	$result                             = new JSend('success', (array)$this->shipment);
    	
    	//jika ada nomor resi, menuliskan log
    	if(!is_null($this->shipment->receipt_number))
        {
            $result                         = $this->dispatch(new ChangeStatus($this->shipment->transaction, 'shipping'));
        }

        return $result;
    }
}
