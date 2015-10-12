<?php

namespace App\Jobs;
use App\Libraries\JSend;
use \Validator;
use App\Jobs\Job;
use App\Models\user;
use Illuminate\Contracts\Bus\SelfHandling;

class CheckIsCustomerProfileCompleted extends Job implements SelfHandling
{
    protected $user;

    protected $rules            =   [
                                        'name'                 => 'required',
                                        'email'                => 'required',
                                        'gender'               => 'required',
                                        'date_of_birth'        => 'required',
                                        'address'              => 'required',
                                        'phone'                => 'required',
                                        'postal_code'          => 'required',
                                    ];    

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


        //validate
        $validator              = Validator::make((array)$this->user['attributes'], (array)$this->rules);

        if ($validator->passes())
        {
            $result                 = new Jsend('success', (array)$this->user);
        }
        else
        {
            $result                 = new Jsend('error', (array)$this->user, (array)$validator->errors());
        }

        return $result;
    }
}
