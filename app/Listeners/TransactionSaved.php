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
    
    public function __construct()
    {
        //
    }

    public function handle(Transaction $transaction)
    {
        $result					= $this->dispatch(new SwitchTransaction($transaction));

        return $result;
    }
}