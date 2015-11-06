<?php

namespace App\Jobs\Models\StoreSetting;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\StoreSetting;
use App\Jobs\Auditors\SaveAuditPolicy;

class StoreSettingSaved extends Job implements SelfHandling
{
    use DispatchesJobs;
    
    protected $store;

    public function __construct(StoreSetting $store)
    {
        $this->store				= $store;
    }

    public function handle()
    {
		$result						= $this->dispatch(new SaveAuditPolicy($this->store));
        
        return $result;
    }
}
