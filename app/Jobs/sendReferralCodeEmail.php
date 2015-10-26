<?php

// ===================================
// referral code must be saved first.
// ===================================


namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class sendReferralCodeEmail extends Job implements SelfHandling
{
    use DispatchesJobs;

    public function __construct(user $user)
    {
        $this->user()               => $user;
    }


    public function handle()
    {
        try
        {
             // checking
            if(is_null($this->transaction->id))
            {
                throw new Exception('Sent variable must be object of a record.');
            }

            //send email
            $mail_data      = [
                                'view'          => 'emails.test', 
                                'datas'         => $this->user->referral_code, 
                                'dest_email'    => $this->user->email, 
                                'dest_name'     => $this->user->name, 
                                'subject'       => 'Billing Information', 
                            ];   

            // call email send job
            $this->dispatch(new Mailman($mail_data));
            
            return new JSend('success', (array)$this->transaction)  ;           
        }
        catch (Exception $e) 
        {
            $this->release(10);
        }                             
    }
}
