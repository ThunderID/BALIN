<?php

namespace App\Jobs\Models\StoreSetting;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\StoreSetting;
use Carbon;

class StoreSettingSaving extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $store;

    public function __construct(StoreSetting $store)
    {
        $this->store                = $store;
    }

    public function handle()
    {
        //cek 
        $result                     = new JSend('success', (array)$this->store);
        
        return $result;
    }
}
