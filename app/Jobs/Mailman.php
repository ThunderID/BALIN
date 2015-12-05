<?php

namespace App\Jobs;

use App\Jobs\Job;
use Config;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Libraries\JSend;

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
            Mail::send($this->mail_data['view'], ['data' => $this->mail_data['datas']], function($message)
            {
                $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                // $message->from('help@balin.id'), 'Balin.id');
                $message->to($this->mail_data['dest_email'], $this->mail_data['dest_name'])->subject($this->mail_data['subject']);
            }); 
        
            $result                 = new JSend('success', null);
        }
        catch (\Exception $e) 
        {
            $result                 = new JSend('error', null, $e);
        }
        
        return $result;        
    }
}
