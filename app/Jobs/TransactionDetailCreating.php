<?php

namespace App\Jobs;

use App\Libraries\JSend;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class TransactionDetailCreating extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result                     = new Jsend('success', ['message' => 'Success']);
        return $result;
    }
}