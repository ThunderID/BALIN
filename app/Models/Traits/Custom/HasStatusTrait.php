<?php namespace App\Models\Traits\Custom;

use DB;

trait HasStatusTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasStatusTraitConstructor()
	{
		//
	}

	public function scopeJoinTransaction($query, $variable)
	{
		return $query->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
		;
	}

	public function scopeTransactionLogStatus($query, $variable)
	{
		if(!is_array($variable))
		{
			return $query->leftjoin('transaction_logs', function ($join) use($variable) 
			{
				$join
					->on('transaction_logs.transaction_id', '=', 'transactions.id')
					->where('transaction_logs.status', '=', $variable)
					->Where('transaction_logs.changed_at', '=', DB::raw('(select max(changed_at) from transaction_logs as tl2 where tl2.transaction_id = transaction_logs.transaction_id )'))
					;
			});

			// return $query->leftjoin(DB::raw('(SELECT status, transaction_id, changed_at from transaction_logs as tlogs1 where changed_at = (SELECT MAX(changed_at) FROM transaction_logs AS tlogs2 WHERE tlogs1.transaction_id = tlogs2.transaction_id and tlogs2.deleted_at is null) and tlogs1.deleted_at is null group by transaction_id) as transaction_logs'), function ($join) use($variable) 
			// {
			// 	$join
			// 		->on('transaction_logs.transaction_id', '=', 'transactions.id')
			// 		->where('transaction_logs.status' ,'=' , $variable)
			// 		;
			// });
		}
		else
		{
			return $query->leftjoin('transaction_logs', function ($join) use($variable) 
			{
				$join
					->on('transaction_logs.transaction_id', '=', 'transactions.id')
					->whereIn('transaction_logs.status' , $variable)
					->Where('transaction_logs.changed_at', '=', DB::raw('(select max(changed_at) from transaction_logs as tl2 where tl2.transaction_id = transaction_logs.transaction_id )'))
					;
			});

			// return $query->leftjoin(DB::raw('(SELECT status, transaction_id, changed_at from transaction_logs as tlogs1 where changed_at = (SELECT MAX(changed_at) FROM transaction_logs AS tlogs2 WHERE tlogs1.transaction_id = tlogs2.transaction_id and tlogs2.deleted_at is null) and tlogs1.deleted_at is null group by transaction_id) as transaction_logs'), function ($join) use($variable) 
			// {
			// 	$join
			// 		->on('transaction_logs.transaction_id', '=', 'transactions.id')
			// 		->whereIn('transaction_logs.status' , $variable)
			// 		;
			// });
		}
	}
	
	public function scopeTransactionLogChangedAt($query, $variable)
	{
		if(!is_array($variable))
		{
			return $query->where('changed_at', '<=', date('Y-m-d H:i:s', strtotime($variable)))->orderBy('changed_at', 'desc');
		}

		return $query->where('changed_at', '>=', date('Y-m-d H:i:s', strtotime($variable[0])))->where('changed_at', '<=', date('Y-m-d H:i:s', strtotime($variable[1])))->orderBy('changed_at', 'asc');
	}
	
	public function scopeExtendTransactionType($query, $variable)
	{
		if(is_array($variable))
		{
			return $query->whereIn('transactions.type', $variable)
			;
		}
		else
		{
			return $query->where('transactions.type', $variable)
			;
		}
	}

	public function scopeTransactionStockOn($query, $variable)
	{
		return $query->jointransaction(true)->transactionlogstatus($variable)->extendtransactiontype(['sell', 'buy'])
		;
	}

	public function scopeTransactionSellOn($query, $variable)
	{
		return $query->jointransaction(true)->transactionlogstatus($variable)->extendtransactiontype('sell')
		;
	}

	public function scopeTransactionBuyOn($query, $variable)
	{
		return $query->jointransaction(true)->transactionlogstatus($variable)->extendtransactiontype('buy')
		;
	}
}