<?php namespace App\Models\Traits\belongsTo;

trait HasTransactionDetailTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasTransactionDetailTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function TransactionDetail()
	{
		return $this->belongsTo('App\Models\TransactionDetail');
	}

	public function scopeHasTransactionDetail($query, $variable)
	{
		return $query->whereHas('transactiondetail', function($q)use($variable){$q;});
	}

	public function scopeTransactionDetailID($query, $variable)
	{
		return $query->whereHas('transactiondetail', function($q)use($variable){$q->id($variable);});
	}
}