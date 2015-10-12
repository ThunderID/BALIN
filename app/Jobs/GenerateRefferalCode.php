<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\user;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;


class GenerateRefferalCode extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $user;

    public function __construct(user $user)
    {
        $this->user             = $user;
    }

    public function handle()
    {
        // checking
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //check is user doesnt have refferal code yet
        if($this->user['referral_code'])
        {
            $result                 = Jsend('error', (array)$this->user, 'Referral code allready exist');
        }
        else
        {
            $transac_data           = $this->dispatch(new CheckIsCustomerHasProcessedTransaction($this->user));

            if($transac_data->getstatus() == 'success')
            {
                //generate refferal code
                $name               = preg_split('/\s+/', $this->user['name']);
                $uid                = $this->user['id'];

                $ref_code           = $name[0] . $uid;

                $data               = $this->user;

                $data->fill([
                    'referral_code' => $ref_code
                ]);

                if($data->save())
                {
                    $result         = new Jsend('success', (array)$data);
                }
                else
                {
                    $result         = new Jsend('error', (array)$this->user, (array)$data->getError());
                }

            }
            else
            {
                $result             = $transac_data;
            }            
        }

        return $result;
    }
}