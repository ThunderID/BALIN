<?php

namespace App\Jobs\Models\Varian;

use App\Jobs\Job;
use App\Jobs\SendVarianEmail;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\Varian;
use App\Libraries\JSend;

class VarianSaved extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $varian;

    public function __construct(Varian $varian)
    {
        $this->varian                 = $varian;
    }

    public function handle()
    {
        $result                         = new JSend('success', (array)$this->varian);

        return $result;
    }
}
