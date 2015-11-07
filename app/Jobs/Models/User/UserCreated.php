<?php

namespace App\Jobs\Models\User;

use App\Jobs\Job;
use App\Jobs\AddQuotaRegistration;
use App\Jobs\SendWelcomeEmail;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\User;

class UserCreated extends Job implements SelfHandling
{
    use DispatchesJobs;
    
    protected $user;

    public function __construct(User $user)
    {
        $this->user					= $user;
    }

    public function handle()
    {
        $result						= $this->dispatch(new AddQuotaRegistration($this->user));
        
        if($result->getStatus()=='success')
        {
	        $result					= $this->dispatch(new SendWelcomeEmail($this->user));
        }
        
        return $result;
    }
}
