<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\user;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests

class SendResetPasswordEmail extends Job implements SelfHandling
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
        $datas                              = $this->dispatch(new GenerateResetPasswordEmail($this->user));        

        //send email
        $mail_data      = [
                            'view'          => 'emails.test', 
                            'datas'         => (array)$datas, 
                            'dest_email'    => 'budi-purnomo@outlook.com', 
                            'dest_name'     => 'budi purnomo', 
                            'subject'       => 'Password Reset', 
                        ];

        // call email send job
        $this->dispatch(new Mailman($mail_data));

        return true;
}
