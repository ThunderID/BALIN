<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\user;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Libraries\JSend;

class SendActivationEmail extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;
    
    protected $user;

    public function __construct(User $user)
    {
        $this->user                         = $user;
    }

    public function handle()
    {
        // checking
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //send email
        $mail_data      = [
                            'view'          => 'emails.activation', 
                            'datas'         =>  [
                                                    'name' => $this->user->name,
                                                    'activation_link' => $this->user->activation_link
                                                ], 
                            'dest_email'    => $this->user->email, 
                            'dest_name'     => $this->user->name, 
                            'subject'       => '[BALIN] Email Activation', 
                        ];

        // call email send job
        $this->dispatch(new Mailman($mail_data));

        return new JSend('success', (array)$this->user);
    }
}
