<?php namespace App\Models\Traits\hasMany;

use DB;

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
		return $query
			->selectraw('transactions.*')
			->selectraw('transaction_logs.status as current_status')
			->transactionlogstatus($variable);
			
		if(!is_array($variable))
		{
			return $query->join(DB::raw('(SELECT status, transaction_id, changed_at from transaction_logs as tlogs1 where changed_at = (SELECT MAX(changed_at) FROM transaction_logs AS tlogs2 WHERE tlogs1.transaction_id = tlogs2.transaction_id and tlogs2.deleted_at is null) and tlogs1.deleted_at is null group by transaction_id) as transaction_logs'), function ($join) use($variable) 
			{
				$join
					->on('transaction_logs.transaction_id', '=', 'transactions.id')
					->where('transaction_logs.status' ,'=' , $variable)
					;
			});
		}
		else
		{

			return $query->join(DB::raw('(SELECT status, transaction_id, changed_at from transaction_logs as tlogs1 where changed_at = (SELECT MAX(changed_at) FROM transaction_logs AS tlogs2 WHERE tlogs1.transaction_id = tlogs2.transaction_id and tlogs2.deleted_at is null) and tlogs1.deleted_at is null group by transaction_id) as transaction_logs'), function ($join) use($variable) 
			{
				$join
					->on('transaction_logs.transaction_id', '=', 'transactions.id')
					->whereIn('transaction_logs.status' , $variable)
					;
			});
		}
	}
}