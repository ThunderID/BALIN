<?php

namespace App\Jobs;

//to count how much point cuts for trs
use App\Jobs\Job;

use App\Models\User;
use App\Models\UserCampaign;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use Exception;

class SaveCampaign extends Job implements SelfHandling
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user                         = $user;
    }

    public function handle()
    {
        $result                             = new JSend('success', (array)$this->user);

        $campaign                           = UserCampaign::userid($this->user->id)->type($this->user->campaign_type)->first();

        if($campaign)
        {
            $result                         = new JSend('error', (array)$this->user, 'Tidak dapat mengikuti campaign ini.');
        }
        else
        {
            $usercamp                       = new UserCampaign;

            $usercamp->fill([
                    'user_id'               => $this->user->id,
                    'type'                  => $this->user->campaign_type,
                    'is_used'               => false,
                ]);

            if(!$usercamp->save())
            {
                $result                     = new JSend('error', (array)$this->user, $usercamp->getError());
            }
        }

        return $result;
    }
}
