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
            $reference                  = PointLog::referenceid($this->pointlog->reference_id)->first();
            if($reference && $this->pointlog->user_id == $reference->reference_id)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Tidak dapat memakai referensi dari pemberi referens.');
            }
            elseif($this->pointlog->user_id == $this->pointlog->reference_id)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Tidak dapat referral code anda sebagai pemberi referens.');
            }
            else
            {
                $gift                   = StoreSetting::type('invitation_royalty')->Ondate('now')->first();

                if(!$gift)
                {
                    $result             = new JSend('error', (array)$this->pointlog, 'Tidak ada campaign untuk point reference.');
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
