<?php

namespace App\Jobs\Models\Price;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Libraries\JSend;

use App\Models\Price;

use App\Jobs\Auditors\SaveAuditPrice;

class PriceSaved extends Job implements SelfHandling
{
    use DispatchesJobs;
    
    protected $price;

    public function __construct(Price $price)
    {
        $this->price                    = $price;
    }

    public function handle()
    {
        if(date('Y-m-d H:i:s') >= $this->price->started_at)
        {
            return new JSend('error', (array)$this->price, 'Tidak bisa edit harga yang telah dimulai');
        }

        $result                         = $this->dispatch(new SaveAuditPrice($this->price));

        return $result;
    }
}
