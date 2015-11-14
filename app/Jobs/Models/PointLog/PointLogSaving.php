<?php

namespace App\Jobs\Models\PointLog;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\PointLog;
use App\Models\StoreSetting;
use App\Libraries\JSend;

class PointLogSaving extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $pointlog;

    public function __construct(PointLog $pointlog)
    {
        $this->pointlog                 = $pointlog;
    }

    public function handle()
    {
        //jika reference dari user
        if($this->pointlog->reference_type=='App\Models\User')
        {
            //Check referee
            $reference                  = PointLog::referenceid($this->pointlog->reference_id)->referencetype('App\Models\User')->first();
            if($reference && $this->pointlog->user_id == $reference->reference_id)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Tidak dapat memakai referensi dari pemberi referens.');
            }
            elseif($this->pointlog->user_id == $this->pointlog->reference_id)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Tidak memakai dapat referral code anda sebagai pemberi referens.');
            }
            elseif($this->pointlog->reference->quota <= 0)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Untuk saat ini tidak dapat menggunakan referral code '.$this->pointlog->reference->name);
            }
            else
            {
                $gift                   = StoreSetting::type('invitation_royalty')->Ondate('now')->first();

                if(!$gift)
                {
                    $result             = new JSend('error', (array)$this->pointlog, 'Tidak ada campaign untuk point reference.');
                }
                elseif($this->pointlog->reference->voucher->value!=0)
                {
                    //temporary
                    $this->pointlog->amount = $this->pointlog->reference->voucher->value;
                    $this->pointlog->notes  = 'Referensi promo '.$this->pointlog->reference->name;
                    $result                 = new JSend('success', (array)$this->pointlog);
                }
                else
                {
                    //temporary
                    $this->pointlog->amount = $gift->value;
                    $this->pointlog->notes  = 'Direferensikan '.$this->pointlog->reference->name;
                    $result                 = new JSend('success', (array)$this->pointlog);
                }
                
            }
        }
        else
        {
            $result                     = new JSend('success', (array)$this->pointlog);
        }

        return $result;
    }
}
