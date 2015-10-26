<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;
use App\Models\Policy;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag as MessageBag;
use App\Libraries\JSend;

class GenerateActivationEmail extends Job implements SelfHandling
{
 protected $user;

    public function __construct(User $user)
    {
        $this->user           = $user;
    }

    public function handle()
    {
        //generate link
        $activation                 = md5(uniqid(rand(), TRUE));
        $ttl                        = Policy::GetTTL('now')->first();

        $data                       =   [
                                            'activation_link'  => $activation,
                                            'expired_at'       => date('Y-m-d H:i:s', strtotime($ttl)),
                                        ];

        $result                     = new JSend('success', (array)$data);

        return $result;
    }
}
