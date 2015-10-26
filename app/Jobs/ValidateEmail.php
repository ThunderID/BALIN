<?php

namespace App\Jobs;

use App\Libraries\JSend;
use App\Jobs\Job;
use App\Models\user;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ValidateEmail extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $user;

    public function __construct(user $user)
    {
        $this->user                          = $user;
    }

    public function handle()
    {
        // checking
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //validate
        $validate                            = $this->dispatch(new CheckValidationLink($this->user));

        if($validate->getstatus() == 'success')
        {
            $data                           = $this->user;

            $data->fill([
                    'activation_link'       => null,
                    'expired_at'            => null,
                    'is_active'             => 1
                ]);

            if($data->save())
            {
                $result                     = new Jsend('success', (array)$data);
            }
            else
            {
                $result                     = new Jsend('error', (array)$this->user, (array)$data->getError());
            }
        }
        else
        {
            $result                         = new Jsend('error', (array)$this->user, (array)$validate);
        }

        return $result;
    }
}
