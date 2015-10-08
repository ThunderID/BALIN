<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\user;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Bus\SelfHandling;

class SendBillingEmail extends Job implements SelfHandling
{
    protected $user;

    public function __construct(user $user)
    {
        $this->user             = $user;
    }

    public function handle(Mailer $mail)
    {
        // checking
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }
        
        //get Billing
        $Bills                   = $this->getBill();

        //send email
        $mail->send('emails.test', ['Bills' => $Bills], function($message)
        {
            $message->to($this->user['email'], $this->user['name'])->subject('Billing Statement');
        });   

        return true;
    }

    public function getBill()
    {
        // call job get bill
        return "a";
    }
}
