<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\user;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Bus\SelfHandling;

class SendShipmentEmail extends Job implements SelfHandling
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
        $shipment                   = $this->getShipment();

        //send email
        $mail->send('emails.test', ['shipment' => $shipment], function($message)
        {
            $message->to($this->user['email'], $this->user['name'])->subject('Shipping Information');
        });   

        return true;
    }

    public function getShipment()
    {
        // call job get bill
        return "a";
    }  
}
