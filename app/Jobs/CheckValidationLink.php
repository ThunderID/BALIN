<?php

namespace App\Jobs;

use App\Libraries\JSend;
use App\Jobs\Job;
use App\Models\user;
use Illuminate\Contracts\Bus\SelfHandling;

class CheckValidationLink extends Job implements SelfHandling
{
    protected $user;

    public function __construct(user $user)
    {
        $this->user                          = $user;
    }

    public function handle()
    {
        // checking
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //validate
        if($this->user['activation_link'] && $this->user['expired_at'])
        {
            if(date('Y-m-d H:i:s', strtotime('now')) <= $this->user['expired_at'])
            {
                $result                     = new Jsend('success', (array)$this->user);
            }
            else
            {
                $result                     = new Jsend('error', (array)$this->user, 'Activation code expired');
            }
        }
        else
        {
            $result                         = new Jsend('error', (array)$this->user, 'Activation code not found');
        }

        return $result;
    }
}
