<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Bus\SelfHandling;

class Mailman extends Job implements SelfHandling
{
    protected $mail_data;

    public function __construct(array $mail_Data)
    {
        $mail_data                  = $mail_Data;
    }

    public function handle()
    {
        try
        {
            $mail->send($this->email_data['view'], $this->email_data['data'], function($message)
            {
                $message->to($this->email_data['email'], $this->email_data['name'])->subject($this->email_data['subject']);
            }); 
        
            $result                 = new Jsend('success', null);
        }
        catch (Exception $e) 
        {
            $result                 = new Jsend('error', null, $e);
        }       
        
        return $result;        
    }
}
