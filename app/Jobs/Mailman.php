<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Bus\SelfHandling;

class Mailman extends Job implements SelfHandling
{
    protected $mail_data;

    public function __construct(array $mail_data)
    {
        $this->mail_data            = $mail_data;
    }

    public function handle(Mailer $mail)
    {
        try
        {
            $mail->send($this->mail_data['view'], $this->mail_data['data'], function($message)
            {
                $message->to($this->mail_data['email'], $this->mail_data['name'])->subject($this->mail_data['subject']);
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
