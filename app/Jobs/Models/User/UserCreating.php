<?php

namespace App\Jobs\Models\User;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Jobs\GenerateActivationEmail;

use App\Models\User;

class UserCreating extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;
    
    protected $user;

    public function __construct(User $user)
    {
        $this->user                 = $user;
    }

    public function handle()
    {
     //    $this->user->is_active      = false;
    	// $this->user->joined_at 		= date('Y-m-d H:i:s');

     //    $activationlink             = $this->dispatch(new GenerateActivationEmail($this->user));

     //    if($activationlink->getStatus()=='success')
     //    {
     //        $this->user->activation_link    = $activationlink->getData()['activation_link'];
     //        $this->user->expired_at         = $activationlink->getData()['expired_at'];
     //    }
     //    else
     //    {
     //        return $activationlink;
     //    }
    	
        return new JSend('success', (array)$this->user);
    }
}
