<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Transaction;
use App\Jobs\SwitchTransaction;

class TransactionSaved
{
    use DispatchesJobs, ValidatesRequests;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Session  $event
     * @return void
     */
    public function handle(Transaction $transaction)
    {
        $result					= $this->dispatch(new SwitchTransaction($transaction));

        return $result;
    }
}