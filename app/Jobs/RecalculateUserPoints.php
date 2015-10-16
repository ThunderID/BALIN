<?php

namespace App\Jobs;

use DB;

use App\Jobs\Job;

use App\Models\user;
use App\Models\pointlog;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

class RecalculateUserPoints extends Job implements SelfHandling
{
    protected $user;

    public function __construct(user $user)
    {
        $this->user                          = $user; 
    }

    public function handle()
    {
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //calculate valid points
        $points                             = pointlog::where('user_id',$this->user->id)
                                                        ->where('expired_date','>=', date('Y-m-d H:i:s', strtotime('now') ))
                                                        ->select(DB::raw('sum(debit) - sum(credit) AS total_points'))
                                                        ->first();

        //update user's points
        $data                               = $this->user;
        $data->fill([
                'balance'                  => $points['total_points']
            ]);

        if(!$data->save())
        {
            return false;
            // $result                         = new Jsend('error', (array)$data, (array)$data->getError());
        }
        else
        {
            return true;
            // $result                         = new Jsend('success', ['message' => 'Points recalculated']);
        }

    }
}
