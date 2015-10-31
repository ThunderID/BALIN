<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Addres;

class AddressSaved extends Job implements SelfHandling
{
    public function __construct(address $address)
    {
        $this->address              = $address;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->courier);
    }
}