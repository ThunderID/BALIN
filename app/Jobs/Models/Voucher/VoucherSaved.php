<?php

namespace App\Jobs\Models\Voucher;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\Voucher;

use App\Jobs\Auditors\SaveAuditVoucher;

class VoucherSaved extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher					= $voucher;
    }

    public function handle()
    {
		$result							= $this->dispatch(new SaveAuditVoucher($this->voucher));

        return $result;
    }
}
