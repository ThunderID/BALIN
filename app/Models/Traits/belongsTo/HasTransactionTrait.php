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

	public function scopeTransactionUser($query, $variable)
	{
		return $query->whereHas('transaction', function($q)use($variable){$q->userid($variable);});
	}
	
	public function scopeDoesntHaveTransaction($query, $variable)
	{
		return $query->whereDoesntHave('transaction', function($q)use($variable){$q;});
	}

	
}