<?php

namespace App\Jobs\Models\User;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\User;

class UserCreating extends Job implements SelfHandling
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user                 = $user;
    }

    public function handle()
    {
    	$this->user->joined_at 		= date('Y-m-d H:i:s');
    	
        return new JSend('success', (array)$this->user);
    }
}
