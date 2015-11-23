<?php

namespace App\Jobs\Models\Address;

use App\Jobs\Models\AddressJob;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Address;

class AddressUpdated extends Job implements SelfHandling
{
    public function __construct(Address $address)
    {
        $this->address              = $address;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->address);
    }
}
