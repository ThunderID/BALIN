<?php

namespace App\Jobs\Models\PointLog;

use App\Jobs\Job;
use App\Jobs\CreditQuota;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\PointLog;
use App\Models\Voucher;
use App\Models\UserCampaign;
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
            //Check campaign
            // $usercampaign               = UserCampaign::userid($this->pointlog->user_id)->used(false)->type('referral')->first();
            //Check referee
            $reference                  = PointLog::referenceid($this->pointlog->reference_id)->referencetype('App\Models\User')->first();
            $user                       = PointLog::userid($this->pointlog->user_id)->referencetype('App\Models\User')->first();
            $alreadyhasvoucher          = PointLog::userid($this->pointlog->user_id)->referencetype('App\Models\Voucher')->first();

            // if(!$usercampaign)
            // {
            //     $result                 = new JSend('error', (array)$this->pointlog, 'Tidak dapat dapat menyimpan pemberi referral.');
            // }
            // elseif($reference && $this->pointlog->user_id == $reference->reference_id)
            if($user || $alreadyhasvoucher)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Maaf, Anda tidak dapat menambahkan referral code, karena anda sudah menggunakan referral code '.$this->pointlog->reference->referral_code);
            }
            elseif($reference && $this->pointlog->user_id == $reference->reference_id)
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
            elseif($user)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Sudah memiliki referens.');
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

            if($result->getStatus()=='success')
            {
                $result                 = $this->dispatch(new CreditQuota($this->pointlog->reference->voucher, 'Mereferensikan '.$this->pointlog->user->name));
            }

        }
        elseif($this->pointlog->reference_type=='App\Models\Voucher')
        {
            //Check referee
            // $usercampaign               = UserCampaign::userid($this->pointlog->user_id)->used(false)->type($this->pointlog->reference->type)->first();
            $reference                      = PointLog::referenceid($this->pointlog->reference->user_id)->referencetype('App\Models\User')->first();
            $user                           = PointLog::userid($this->pointlog->reference->user_id)->referencetype('App\Models\User')->first();
            $alreadyhasvoucher              = PointLog::userid($this->pointlog->user_id)->referencetype('App\Models\Voucher')->first();
            $alreadyhasreferral             = PointLog::userid($this->pointlog->user_id)->referencetype('App\Models\User')->first();

            // if(!$usercampaign)
            // {
            //     $result             = new JSend('error', (array)$this->pointlog, 'Maaf, anda tidak terdaftar untuk campaign ini.');
            // }
            // elseif($reference && $this->pointlog->user_id == $reference->reference_id)
            if($alreadyhasvoucher || $alreadyhasreferral)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Maaf, Anda sudah mempunyai referral code.');
            }
            elseif($reference && $this->pointlog->user_id == $reference->reference_id)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Tidak dapat memakai referensi dari pemberi referens.');
            }
            elseif($this->pointlog->user_id == $this->pointlog->reference->user_id)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Tidak memakai dapat referral code anda sebagai pemberi referens.');
            }
            elseif($this->pointlog->reference->quota <= 0)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Untuk saat ini tidak dapat menggunakan referral code '.$this->pointlog->reference->user->name);
            }
            elseif($user)
            {
                $result                 = new JSend('error', (array)$this->pointlog, 'Sudah memiliki referens.');
            }
            else
            {
                $prev_reference         = $this->pointlog->reference_id;

                $gift                   = StoreSetting::type('invitation_royalty')->Ondate('now')->first();

                if(!$gift)
                {
                    $result             = new JSend('error', (array)$this->pointlog, 'Tidak ada campaign untuk point reference.');
                }
                elseif($this->pointlog->reference->value!=0)
                {
                    //temporary
                    $this->pointlog->amount = $this->pointlog->reference->value;
                    $this->pointlog->notes  = 'Referensi promo #'.$this->pointlog->reference->code;
                    $result                 = new JSend('success', (array)$this->pointlog);
                }
                else
                {
                    //temporary
                    $this->pointlog->amount = $gift->value;
                    $this->pointlog->notes  = 'Direferensikan '.$this->pointlog->reference->user->name;
                    $result                 = new JSend('success', (array)$this->pointlog);
                }
                
                if($result->getStatus()=='success')
                {
                    $result                 = $this->dispatch(new CreditQuota(Voucher::findorfail($prev_reference), 'Mereferensikan '.$this->pointlog->user->name));
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
