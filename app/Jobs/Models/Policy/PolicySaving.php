<?php

namespace App\Jobs\Models\Policy;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Policy;
use Carbon;

class PolicySaving extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $policy;

    public function __construct(Policy $policy)
    {
        $this->policy                = $policy;
    }

    public function handle()
    {
        //cek 
        if(date('Y-m-d H:i:s') >= $this->policy->started_at)
        {
            return new JSend('error', (array)$this->policy, 'Tidak bisa mengubah policy yang sudah ditetapkan.');
        }

        return new JSend('success', (array)$this->policy);
    }
}
