<?php namespace App\Models\Traits\belongsToMany;

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
		return $this->belongsToMany('App\Models\Transaction', 'transactions_details');
	}
}