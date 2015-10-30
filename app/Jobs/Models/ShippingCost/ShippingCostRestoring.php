<?php

namespace App\Jobs\Models\ShippingCost;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\ShippingCost;

class ShippingCostRestoring extends Job implements SelfHandling
{
    protected $shippingcost;

    public function __construct(ShippingCost $shippingcost)
    {
        $this->shippingcost             = $shippingcost;
    }

    public function handle()
    {
        $result                         = new JSend('success', (array)$this->shippingcost);
        
        return $result;
    }
}
