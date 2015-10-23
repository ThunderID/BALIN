<?php

namespace App\Jobs\Models\Courier;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Courier;

class CourierCreating extends Job implements SelfHandling
{
    protected $courier;

    public function __construct(Courier $courier)
    {
        $this->courier             = $courier;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->courier);
    }
}
