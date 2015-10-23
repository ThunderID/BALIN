<?php

namespace App\Jobs\Models\Supplier;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Supplier;

class SupplierUpdating extends Job implements SelfHandling
{
    protected $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier             = $supplier;
    }

    public function handle()
    {
        $result                     = new Jsend('success', (array)$this->supplier);
    }
}
