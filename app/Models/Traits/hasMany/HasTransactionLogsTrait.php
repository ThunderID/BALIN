<?php namespace App\Models\Traits\hasMany;

trait HasTransactionLogsTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasTransactionLogsTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function TransactionLogs()
	{
		return $this->hasMany('App\Models\TransactionLog');
	}

	public function scopeHasTransactionLogs($query, $variable)
	{
		return $query->whereHas('transactionlogs', function($q)use($variable){$q;});
	}

	public function scopeTransactionLogID($query, $variable)
	{
		return $query->whereHas('transactionlogs', function($q)use($variable){$q->id($variable);});
	}

	public function scopeStatus($query, $variable)
	{
		return $query->whereHas('transactionlogs', function($q)use($variable){$q->status($variable);});
	}
}