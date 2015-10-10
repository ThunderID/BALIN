<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\user;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Bus\SelfHandling;

class sendActivationEmail extends Job implements SelfHandling
{
    protected $user;

    public function __construct(user $user)
    {
        $this->user             = $user;
    }


    public function handle()
    {
        // checking
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }
        
        //get Billing
        $datas                              = $this->dispatch(new GenerateActivationEmail($this->user));        

        //send email
        $mail_data      = [
                            'view'          => 'emails.test', 
                            'datas'         => (array)$datas, 
                            'dest_email'    => 'budi-purnomo@outlook.com', 
                            'dest_name'     => 'budi purnomo', 
                            'subject'       => 'Email Activation', 
                        ];

        // call email send job
        $this->dispatch(new Mailman($mail_data));

        return true;
    }
}
