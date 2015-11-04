<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Models\User;
use App\Models\StoreSetting;
use Exception;
use App\Libraries\JSend;

class SendReferralCodeEmail extends Job implements SelfHandling
{
    use DispatchesJobs;

    public function __construct(User $user)
    {
        $this->user         = $user;
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

        $datas          = ['user' => (array)$this->user['attributes'], 'balin' => $infos];

        $mail_data      = [
                            'view'          => 'emails.referral', 
                            'datas'         => $datas, 
                            'dest_email'    => $this->user->email, 
                            'dest_name'     => $this->user->name, 
                            'subject'       => 'Referral Code', 
                        ];   

        // call email send job
        $this->dispatch(new Mailman($mail_data));
        
        return new JSend('success', (array)$this->user);
    }
}
