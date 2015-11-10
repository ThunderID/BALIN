<?php namespace App\Models\Traits\belongsToManyThrough;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Varian;
use DB;

trait HasTransactionsTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasTransactionsTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Transactions()
	{
		$tdetail 		= $this->transactiondetails;

	    return $this->transactiondetails->transaction;
	}
}