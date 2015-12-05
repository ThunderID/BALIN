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
use App\Models\Voucher;
use App\Models\StoreSetting;
use App\Models\UserCampaign;

use App\Jobs\Auditors\SaveAuditPoint;
use App\Jobs\SendWelcomeCampaignEmail;

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
                $voucher                = Voucher::userid($this->pointlog->reference_id)->first();
                if($voucher && $voucher['type']=='referral' && $voucher['value']==0)
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
                        $result             = new JSend('error', (array)$this->pointlog, $referee->getError());
                    }
                }

                $user                   = UserCampaign::userid($this->pointlog->user_id)->used(false)->type($voucher['type'])->first();
                if($user)
                {
                    $user->is_used          = true;

                    $user->save();
                }
            }
        }
        elseif($this->pointlog->reference_type=='App\Models\Voucher')
        {
            $user                   = UserCampaign::userid($this->pointlog->user_id)->used(false)->type($this->pointlog->reference->type)->first();
            if($user)
            {
                $user->is_used          = true;

                $user->save();
                
                $result                 = $this->dispatch(new SendWelcomeCampaignEmail($this->pointlog->user, $this->pointlog['amount']));
            }
        }

        if($result->getStatus()=='success')
        {
            $result                     = $this->dispatch(new SaveAuditPoint($this->pointlog));
        }

        return $result;
    }
}
