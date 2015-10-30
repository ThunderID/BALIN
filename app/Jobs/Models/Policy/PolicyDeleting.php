<?php

namespace App\Jobs\Models\Policy;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Policy;

class PolicyDeleting extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $policy;

    public function __construct(Policy $policy)
    {
        $this->policy             = $policy;
    }


    public function handle()
    {
        return new JSend('error', (array)$this->policy, 'Tidak bisa menghapus policy yang sudah ditetapkan.');
    }
}
