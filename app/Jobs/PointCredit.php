<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;
use App\Models\User;
use App\Models\pointlog;
use App\Models\Transaction;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PointCredit extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $inputs;

    public function __construct(array $inputs)
    {
        $this->inputs                 = $inputs;
    }

    public function handle()
    {
        $data                         = new pointlog;

        $user                         = user::find($this->inputs['user_id']);

        //check user existance
        if(!$user)
        {
            throw new Exception('User Not found');
        }

        //count current point


        //validate point before transaction


        //count point expired date
        $rslt                          = $this->dispatch(new CountPointExpirationDate($user));
        if($rslt->getStatus() != 'success')
        {
            return $result;
        }
        $this->inputs['expired_date']  = $rslt->getData()['expired_date'];


        //check transaction existance
        if(transaction::find($this->inputs['transaction_id']))
        {
            $this->inputs['transaction_id'] = 0;
        }        

        try
        {
            $data->fill([
                'transaction_id'        =>$this->inputs['transaction_id'],
                'user_id'               =>$this->inputs['user_id'],           
                'credit'                =>$this->inputs['credit'],
                'expired_date'          =>$this->inputs['expired_date'],
            ]);

            $data->save();

            $result                     = new Jsend('success', ['message' => 'Poin has been added']);

        } 
        catch (Exception $e) 
        {
            $result                     = new Jsend('fail', (array)$e);
        }        

        return $result;        

    }
}
