<?php namespace App\Models\Traits\hasManyThrough;

trait HasTransactionDetailsTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasTransactionDetailsTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function TransactionDetails()
	{
		return $this->hasManyThrough('App\Models\TransactionDetail', 'App\Models\Varian');
	}

	public function scopeHasTransactionDetails($query, $variable)
	{
		return $query->whereHas('transactiondetails', function($q)use($variable){$q;});
	}

	public function scopeTransactionDetailID($query, $variable)
	{
		return $query->whereHas('transactiondetails', function($q)use($variable){$q->id($variable);});
	}
}