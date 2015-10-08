<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use App\Models\Transaction;
use App\Jobs\StockRecalculate;

class TransactionSaved
{
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
    	$flag 					= 0;
    	$result 				= true;

    	if($transaction->status=='paid' && isset($transaction->payments))
    	{
    		$flag 				= 1;
    	}
    	elseif($transaction->status=='shipping' && isset($transaction->shipments) && isset($transaction->payments))
    	{
    		$flag 				= 1;
    	}
    	elseif($transaction->type=='sell' && $transaction->status=='delivered' && isset($transaction->shipments) && isset($transaction->payments) && $transaction->shipments[0]['status']=='delivered')
    	{
    		$flag 				= 1;
    	}
    	elseif(in_array($transaction->status, ['waiting', 'draft']))
    	{
    		$flag 				= 1;
    	}
    	elseif($transaction->type=='buy' && $transaction->status=='delivered')
    	{
    		$flag 				= 1;
    	}

    	if($flag)
    	{
	        $result					= $this->dispatch(new StockRecalculate($transaction));
    	}

        return $result;
    }
}