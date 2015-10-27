<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\shippingcost;

class shippingCostCreating extends Job implements SelfHandling
{
    protected $shippingcost;

    public function __construct(shippingcost $shippingcost)
    {
        $this->shippingcost             = $shippingcost;
    }
    
    public function handle()
    {
        $result                     = new JSend('success', (array)$this->supplier);
        
        return $result;
    }
}
