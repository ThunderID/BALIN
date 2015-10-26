<?php

namespace App\Jobs\Models\User;

use App\Jobs\Job;
use App\Jobs\SendActivationEmail;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\User;

class UserCreated extends Job implements SelfHandling
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user                 = $user;
    }

    public function handle()
    {
        $activationlink             = $this->dispatch(new SendActivationEmail($this->user));
        return $activationlink);
    }
}
