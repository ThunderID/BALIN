<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;
use App\Models\Voucher;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;


class GenerateRefferalCode extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $user;

    public function __construct(User $user)
    {
        $this->user             = $user;
    }

    public function handle()
    {
        // checking
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //check is user doesnt have refferal code yet
        if(!is_null($this->user->voucher))
        {
            $result             = new JSend('error', (array)$this->user, $this->user->name.' sudah memiliki referral code');
        }
        else
        {
            $name               = preg_split('/\s+/', $this->user->name);

            $uid                = $this->user->id;

            $ref_code           = $name[0] . $uid;

            $data               = new Voucher;

            $data->fill
            ([
                'user_id'       => $uid,
                'code'          => $ref_code,
                'type'          => 'referral',
                'expired_at'    => null,
            ]);

            if($data->save())
            {
                $result         = new JSend('success', (array)$data['attributes']);
            }
            else
            {
                $result         = new JSend('error', (array)$this->user, (array)$data->getError());
            }
        }

        return $result;
    }
}