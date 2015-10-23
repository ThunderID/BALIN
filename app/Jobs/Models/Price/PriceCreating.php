<?php

namespace App\Jobs\Models\Price;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Price;

class PriceCreating extends Job implements SelfHandling
{
    protected $price;

    public function __construct(Price $price)
    {
        $this->price                    = $price;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->price);
    }
}
