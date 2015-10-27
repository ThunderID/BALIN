<?php

namespace App\Jobs\Models\Voucher;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\User;
use App\Models\Voucher;

class voucherSaving extends Job implements SelfHandling
{
    protected $voucher;

    public function __construct(voucher $voucher)
    {
        $this->voucher                 = $voucher;
    }

    public function handle()
    {
        $user                          = user::find($this->voucher->user_id);

        if(empty($user))
        {
            return new JSend('error', (array)$this->voucher, ['message' => 'User tidak ditemukan']);
        }

        $voucher                       = voucher::where('user_id', $this->voucher->user_id)->count();

        if($voucher > 0)
        {
            return new JSend('error', (array)$this->voucher, ['message' => 'Voucher user sudah ada']);
        }     

        return new JSend('success', (array)$this->voucher);
    }
}
