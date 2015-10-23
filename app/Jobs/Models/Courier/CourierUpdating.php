<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Courier;

class CourierUpdating extends Job implements SelfHandling
{
    protected $courier;

    public function __construct(Courier $courier)
    {
        $this->courier             = $courier;
    }

    public function handle()
    {
        return new Jsend('success', (array)$this->courier);
    }
}
