<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Models\User;
use App\Models\StoreSetting;
use Exception;
use App\Libraries\JSend;

class SendWelcomeInvitationEmail extends Job implements SelfHandling
{
    use DispatchesJobs;

    public function __construct(User $user, $amount = 0)
    {
        $this->user         = $user;
        $this->amount       = $amount;
    }


    public function handle()
    {
         // checking
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //check store info
        $info           = StoreSetting::storeinfo(true)->take(8)->get();
        $infos          = [];

        foreach ($info as $key => $value) 
        {
            $infos[$value->type]    = $value->value;
        }

        $datas          = ['user' => (array)$this->user['attributes'], 'balin' => $infos, 'amount' => $this->amount];

        $mail_data      = [
                            'view'          => 'emails.welcomeinvitation', 
                            'datas'         => $datas, 
                            'dest_email'    => $this->user->email, 
                            'dest_name'     => $this->user->name, 
                            'subject'       => 'BALIN - Welcome Email', 
                        ];   

        // call email send job
        $this->dispatch(new Mailman($mail_data));
        
        return new JSend('success', (array)$this->user);
    }
}
