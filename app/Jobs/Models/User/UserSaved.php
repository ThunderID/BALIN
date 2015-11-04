<?php

namespace App\Jobs\Models\User;

use App\Jobs\Job;

use App\Jobs\SendReferralCodeEmail;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\User;

class UserSaved extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $user;

    public function __construct(User $user)
    {
        $this->user                 = $user;
    }

    public function handle()
    {
    	// if(!$this->user->is_active && $this->user->email)
    	// {
     //        $result                 = $this->dispatch(new SendReferralCodeEmail($this->user));

     //        if($result->getStatus()=='success')
     //        {
     //            $this->user->is_active  = true;

     //            if($this->user->save())
     //            {
     //                $result         = new JSend('error', (array)$this->user, $this->user->getError());
     //            }
     //        }

     //        return $result;
    	// }

        return new JSend('success', (array)$this->user);
    }
}
