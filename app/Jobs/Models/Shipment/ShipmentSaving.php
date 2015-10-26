<?php

namespace App\Jobs\Models\Shipment;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Shipment;
use App\Models\ShippingCost;
use App\Models\Transaction;

class ShipmentSaving extends Job implements SelfHandling
{
    protected $shipment;

    public function __construct(Shipment $shipment)
    {
        $this->shipment             = $shipment;
    }

    public function handle()
    {
    	//recalculate shipping_cost
    	$shippingcost 				= ShippingCost::courierid($this->shipment->courier_id)->postalcode($this->shipment->postal_code)->first();
    	
    	if($shippingcost)
    	{
    		$transaction 			= Transaction::findorfail($this->shipment->transaction_id);

    		$transaction->fill(['shipping_cost' => $shippingcost->cost]);

    		if($transaction->save())
    		{
	    		$result 			=  new JSend('success', (array)$this->shipment);
    		}
    		else
    		{
	    		$result 			=  new JSend('error', (array)$this->shipment, $transaction->getError());
    		}
    	}
    	else
    	{
    		$result 				=  new JSend('error', (array)$this->shipment, 'Tidak ada kurir ke tempat anda (Silahkan periksa kembali kode pos anda)');
    	}

        return $result;
    }
}
