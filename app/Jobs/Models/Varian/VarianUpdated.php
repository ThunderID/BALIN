<?php

namespace App\Jobs\Models\Varian;

use App\Jobs\Job;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Varian;

class VarianUpdated extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $varian;

    public function __construct(Varian $varian)
    {
        $this->varian						= $varian;
    }

    public function handle()
    {
    	$result                             = new JSend('success', (array)$this->varian);
    	
        return $result;
    }
}
