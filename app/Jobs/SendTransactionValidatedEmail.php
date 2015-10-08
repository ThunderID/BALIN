<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\user;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Bus\SelfHandling;

class SendTransactionValidatedEmail extends Job implements SelfHandling
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
        $Validation                   = $this->getValidation();

        //send email
        $mail->send('emails.test', ['Validation' => $Validation], function($message)
        {
            $message->to($this->user['email'], $this->user['name'])->subject('Transaction Processed');
        });

        return true;
    }

    public function getValidation()
    {
        // call job get bill
        return "a";
    }    
}
