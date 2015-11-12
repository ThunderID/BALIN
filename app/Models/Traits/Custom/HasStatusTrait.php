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
	
	public function scopeTransactionType($query, $variable)
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
		return $query->jointransaction(true)->transactionlogstatus($variable)->transactiontype(['sell', 'buy'])
		;
	}

	public function scopeTransactionSellOn($query, $variable)
	{
		return $query->jointransaction(true)->transactionlogstatus($variable)->transactiontype('sell')
		;
	}

	public function scopeTransactionBuyOn($query, $variable)
	{
		return $query->jointransaction(true)->transactionlogstatus($variable)->transactiontype('buy')
		;
	}
}