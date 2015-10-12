<?php

namespace App\Jobs;

use App\Libraries\JSend;
use App\Jobs\Job;
use App\Models\transaction;
use Illuminate\Contracts\Bus\SelfHandling;

class CancelTransaction extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(transaction $transaction)
    {
        $this->transaction                      = $transaction;
    }

    public function handle()
    {
        $data                                   = $this->transaction;

        $data->fill([
            'status'                            => 'canceled'
        ]);

        if(!$data->save())
        {
            $result                            = new Jsend('error', (array)$this->user, (array)$data->getError());
        }

        $result                                = new Jsend('success', (array)$data);

        return $result;
    }
}
