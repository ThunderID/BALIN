<?php

namespace App\Jobs\Models\Voucher;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Voucher;

class VoucherSaving extends Job implements SelfHandling
{
    protected $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher                 = $voucher;
    }

    public function handle()
    {
        if($this->voucher->user()->count())
        {
            $this->voucher->type        = 'referral';
        }

		if($this->voucher->transactions->count())
		{
			return new JSend('error', (array)$this->voucher, 'Tidak dapat mengubah voucher yang telah digunakan dalam transaksi.');
		}

		return new JSend('success', (array)$this->voucher);

    }
}
