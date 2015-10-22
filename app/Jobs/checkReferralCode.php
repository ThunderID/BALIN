<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;

use App\Models\user;
use App\Models\transaction;

use Illuminate\Contracts\Bus\SelfHandling;

class checkReferralCode extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(transaction $transaction)
    {
        $this->transaction              = $transaction;
    }

    public function handle()
    {
        $rc                             = $this->transaction->referral_code;
        $user                           = user::where('referral_code',$rc)->first();

        if(!empty($user))
        {
            $result                    = new jsend('success', (array)$user);
        }
        else
        {
            $result                    = new jsend('error',  (array)$user, ['message' => 'refferal not found']);
        }

        return $result;
    }
}
