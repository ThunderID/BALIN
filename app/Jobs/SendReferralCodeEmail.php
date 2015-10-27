<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Models\User;
use App\Models\Voucher;
use Exception;
use App\Libraries\JSend;

class SendReferralCodeEmail extends Job implements SelfHandling
{
    use DispatchesJobs;

    public function __construct(User $user, $voucher)
    {
        $this->user         = $user;
        $this->voucher      = $voucher;
    }


    public function handle()
    {
        try
        {
             // checking
            if(is_null($this->user->id))
            {
                throw new Exception('Sent variable must be object of a record.');
            }

            //send email
            $mail_data      = [
                                'view'          => 'emails.test', 
                                'datas'         => (array)$this->voucher['code'], 
                                'dest_email'    => $this->user->email, 
                                'dest_name'     => $this->user->name, 
                                'subject'       => 'Referral Code', 
                            ];   

            // call email send job
            $this->dispatch(new Mailman($mail_data));
            
            return new JSend('success', (array)$this->user);           
        }
        catch (Exception $e) 
        {
            $this->release(10);
        }
    }
}
