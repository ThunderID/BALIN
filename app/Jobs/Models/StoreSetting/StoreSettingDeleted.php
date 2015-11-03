<?php

namespace App\Jobs\Models\StoreSetting;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\StoreSetting;

class StoreSettingDeleted extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $store;

    public function __construct(StoreSetting $store)
    {
        $this->store             = $store;
    }


    public function handle()
    {
        return new JSend('success', (array)$this->store);
    }
}
