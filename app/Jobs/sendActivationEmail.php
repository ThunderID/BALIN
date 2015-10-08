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


    public function handle(Mailer $mail)
    {
        //generate activation link
        $activation             = $this->generateActivationLink();

        //send email
        $mail->send('emails.test', ['activation' => $activation], function($message)
        {
            $message->to($this->user['email'], $this->user['name'])->subject('Email Activation');
        });   

        return true;
    }

    public function generateActivationLink()
    {
        $activation             = md5(uniqid(rand(), TRUE));

        return $activation;
    }
}
