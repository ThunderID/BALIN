<?php namespace App\Models\Traits\belongsTo;

trait HasTransactionTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasTransactionTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Transaction()
	{
		return $this->belongsTo('App\Models\Transaction');
	}

	public function scopeHasTransaction($query, $variable)
	{
		return $query->whereHas('transaction', function($q)use($variable){$q;});
	}

	public function scopeTransactionID($query, $variable)
	{
		return $query->whereHas('transaction', function($q)use($variable){$q->id($variable);});
	}

	public function scopeTransactionUserID($query, $variable)
	{
		return $query->whereHas('transaction', function($q)use($variable){$q->userid($variable);});
	}
	
	public function scopeDoesntHaveTransaction($query, $variable)
	{
		return $query->whereDoesntHave('transaction', function($q)use($variable){$q;});
	}
	
	public function scopeTransactionType($query, $variable)
	{
		return $query->whereHas('transaction', function($q)use($variable){$q->type($variable);});
	}
	
	public function scopeTransactionOndate($query, $variable)
	{
		return $query->whereHas('transaction', function($q)use($variable){$q->ondate($variable);});
	}
	
	public function scopeTransactionStatus($query, $variable)
	{
		return $query
					->join('transactions', function ($join) use($variable) 
						{
							$join->on ( 'shipments.transaction_id', '=', 'transactions.id' )
							->wherenull('transactions.deleted_at')
							;
						})
					->TransactionLogStatus($variable)
					;
	}
}