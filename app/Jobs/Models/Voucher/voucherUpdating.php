<?php

namespace App\Jobs\Models\Voucher;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Voucher;

class voucherUpdating extends Job implements SelfHandling
{
    protected $voucher;

    public function __construct(voucher $voucher)
    {
        $this->voucher                 = $voucher;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->voucher);
    }
}
