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
		if(!is_array($variable))
		{
			return $query->join(DB::raw('(SELECT status, transaction_id, changed_at from transaction_logs as tlogs1 join (select tlogs2.status as status2, max(tlogs2.changed_at) as max_date from transaction_logs as tlogs2 group by tlogs2.transaction_id) as tmp_s on (tmp_s.status2 = tlogs1.status) and tlogs1.changed_at = tmp_s.max_date) as transaction_logs'), function ($join) use($variable) 
			{
				$join
					->on('transaction_logs.transaction_id', '=', 'transactions.id')
					->where('transaction_logs.status' ,'=' , $variable)
					;
			});
		}
		else
		{
			return $query->join(DB::raw('(SELECT status, transaction_id, changed_at from transaction_logs as tlogs1 join (select tlogs2.status as status2, max(tlogs2.changed_at) as max_date from transaction_logs as tlogs2 group by tlogs2.transaction_id) as tmp_s on (tmp_s.status2 = tlogs1.status) and tlogs1.changed_at = tmp_s.max_date) as transaction_logs'), function ($join) use($variable) 
			{
				$join
					->on('transaction_logs.transaction_id', '=', 'transactions.id')
					->whereIn('transaction_logs.status' , $variable)
					;
			});
		}
	}
}