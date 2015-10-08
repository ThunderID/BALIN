<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\user;

use Illuminate\Contracts\Bus\SelfHandling;

class sendActivationEmail extends Job implements SelfHandling
{
    protected $email;

    public function __construct(user $email)
    {
        //
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        // dd($this->email);
    }
}
