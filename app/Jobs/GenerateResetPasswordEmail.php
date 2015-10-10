<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\user;
use App\Models\policy;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag as MessageBag;

class GenerateResetPasswordEmail extends Job implements SelfHandling
{
 protected $user;

    public function __construct(user $user)
    {
        $this->user           = $user;
    }

    public function handle()
    {
        // checking
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //generate link
        $activation                 = md5(uniqid(rand(), TRUE));
        $ttl                        = policy::GetTTL('now')->first;

        $data                       = $this->user;

        $data->fill([
                'reset_password_link'  => $activation;
                'expired_at'           => date('Y-m-d H:i:s', strtotime($ttl));
            ]);

        if($data->save())
        {
            $result                 = new Jsend('success', (array)$data);
        }
        else
        {
            $result                 = new Jsend('error', (array)$this->user, (array)$data->getError());
        }

        return $result;
    }
}
