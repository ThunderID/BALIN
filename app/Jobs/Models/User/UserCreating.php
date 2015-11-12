<?php

namespace App\Jobs\Models\User;

use App\Jobs\Job;
use App\Jobs\GenerateRefferalCode;
use App\Jobs\GenerateActivationLink;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\User;

class UserCreating extends Job implements SelfHandling
{
    use DispatchesJobs;
    
    protected $user;

    public function __construct(User $user)
    {
        $this->user					= $user;
    }

    public function handle()
    {
        $this->user->is_active      = false;
        $result					    = $this->dispatch(new GenerateRefferalCode($this->user));

        if($result->getStatus()=='success')
        {
            //activation link used to generate link for first claimed voucher
            $result                 = $this->dispatch(new GenerateActivationLink($this->user));
        }

        return $result;
    }
}
