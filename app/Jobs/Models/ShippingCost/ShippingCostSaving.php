<?php

namespace App\Jobs\Models\ShippingCost;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\ShippingCost;

class ShippingCostSaving extends Job implements SelfHandling
{
    protected $shippingcost;

    public function __construct(ShippingCost $shippingcost)
    {
        $this->shippingcost             = $shippingcost;
    }
    
    public function handle()
    {
        if($this->shippingcost->start_postal_code > $this->shippingcost->end_postal_code)
        {
            return new JSend('error', (array)$this->shippingcost, 'Kode pos awal harus lebih kecil dari kode pos akhir.');
        }
        if(isset($this->shippingcost->courier_id) && $this->shippingcost->courier_id!=0)
        {
            if(!$this->shippingcost->id)
            {
                $id = 0;
            }
            else
            {
                $id = $this->shippingcost->id;
            }

            $shippingCost                   = ShippingCost::ShippingCost(
                                                        $this->shippingcost->start_postal_code,
                                                        $this->shippingcost->end_postal_code,
                                                        $this->shippingcost->started_at
                                                    )
                                                ->where('started_at','=',date('Y-m-d h:i:s', strtotime($this->shippingcost->started_at)))
                                                ->notid($id)
                                                ->couriernotid($this->shippingcost->courier_id)
                                                ->count();

            if($shippingCost)
            {
                return new JSend('error', (array)$this->shippingcost, 'Tidak dapat menyimpan biaya pengiriman yang tanggal berlakunya telah berlalu.');
            }
        }

        return new JSend('success', (array)$this->shippingcost);
    }
}
