<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Price;

class PriceUpdated extends Job implements SelfHandling
{
    protected $price;

    public function __construct(price $price)
    {
        $this->price                    = $price;
    }

    public function handle()
    {
        return new jsend('success', (array)$this->price);
    }
}
