<?php

namespace App\Jobs\Models\PointLog;

use App\Jobs\Job;
use App\Jobs\CreditQuota;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\User;
use App\Models\PointLog;
use App\Models\QuotaLog;
use App\Models\StoreSetting;

use App\Jobs\Auditors\SaveAuditPoint;

class PointLogSaved extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $pointlog;

    public function __construct(PointLog $pointlog)
    {
        $this->pointlog                 = $pointlog;
    }

    public function handle()
    {
        //jika save referee dari user
        $result                         = new JSend('success', (array)$this->pointlog);

        if($this->pointlog->reference_type=='App\Models\User')
        {
            $gift                       = StoreSetting::type('referral_royalty')->Ondate('now')->first();

            if(!$gift)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Tidak ada campaign untuk point reference.');
            }
            else
            {
                if($this->pointlog->reference->voucher->value==0)
                {
                    $referee            = new PointLog;

                    $referee->fill([
                            'user_id'       => $this->pointlog->reference_id,
                            'amount'        => $gift->value,
                            'expired_at'    => $this->pointlog->expired_at,
                            'notes'         => 'Mereferensikan '.$this->pointlog->user->name,
                        ]);

                    $referee->reference()->associate($this->pointlog);

                    if(!$referee->save())
                    {
                        $result         = new JSend('error', (array)$this->pointlog, $referee->getError());
                    }
                }
            }

            if($result->getStatus()=='success')
            {
                $result                 = $this->dispatch(new CreditQuota($this->pointlog->reference->voucher, 'Mereferensikan '.$this->pointlog->user->name));
            }
        }

        if($result->getStatus()=='success')
        {
            $result                     = $this->dispatch(new SaveAuditPoint($this->pointlog));
        }

        return $result;
    }
}
