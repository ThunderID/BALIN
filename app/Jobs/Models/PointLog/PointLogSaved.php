<?php

namespace App\Jobs\Models\PointLog;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\User;
use App\Models\PointLog;

class PointLogSaved extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $pointlog;

    public function __construct(PointLog $pointlog)
    {
        $this->pointlog                 = $pointlog;
    }

    public function handle()
    {
         //jika save referee dari user
        if($this->pointlog->reference_type=='App\Models\User')
        {
            $referee                    = new PointLog;

            $referee->fill([
                    'user_id'           => $this->pointlog->reference_id,
                    'amount'            => 20000,
                    'expired_at'        => $this->pointlog->expired_at,
                    'notes'             => 'Mereferensikan '.$this->pointlog->user->name,
                ]);

            $referee->reference()->associate($this->pointlog);

            if(!$referee->save())
            {
                $result                 = new JSend('error', (array)$this->pointlog, $referee->getError());
            }
            else
            {
                $result                 = new JSend('success', (array)$this->pointlog);
            }
        }
        else
        {
            $result                     = new JSend('success', (array)$this->pointlog);
        }

        return $result;
    }
}
