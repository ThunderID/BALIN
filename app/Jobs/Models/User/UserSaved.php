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
    	if($this->user->is_active)
    	{
    		return  $this->dispatch(new SendReferralCodeEmail($this->user));
    	}

        return new JSend('success', (array)$this->user);
    }
}
