<?php

namespace App\Jobs\Models\Varian;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Varian;

class VarianCreated extends Job implements SelfHandling
{
    protected $varian;

    public function __construct(Varian $varian)
    {
        $this->varian             = $varian;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->varian);
    }
}
