<?php

namespace App\Jobs\Models\Policy;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Policy;

class PolicyUpdating extends Job implements SelfHandling
{
    protected $policy;

    public function __construct(Policy $policy)
    {
        $this->policy             = $policy;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->policy);
    }
}
