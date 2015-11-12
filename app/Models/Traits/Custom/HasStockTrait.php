<?php namespace App\Models\Traits\Custom;

trait HasStockTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasStockTraitConstructor()
	{
		//
	}

	public function scopeSelectCurrentStock($query, $variable)
	{
		return $query->selectraw('IFNULL(SUM(
									if(transactions.type ="sell", if(transaction_logs.status ="wait" OR transaction_logs.status ="paid" OR transaction_logs.status ="shipping" OR transaction_logs.status ="delivered", 0-quantity, 0), quantity)
									),0) as current_stock')
		;
	}
	
	public function scopeSelectOnHoldStock($query, $variable)
	{
		return $query->selectraw('IFNULL(SUM(
									if(transactions.type ="sell", if(transaction_logs.status ="wait" OR transaction_logs.status ="paid", quantity, 0), 0)
									),0) as on_hold_stock')
		;
	}

	public function scopeSelectInventoryStock($query, $variable)
	{
		return $query->selectraw('IFNULL(SUM(
									if(transactions.type ="sell", if(transaction_logs.status ="shipping" OR transaction_logs.status ="delivered", 0-quantity, 0), quantity)
									),0) as inventory_stock')
		;
	}

	public function scopeSelectReservedStock($query, $variable)
	{
		return $query->selectraw('IFNULL(SUM(
									if(transactions.type ="sell", if(transaction_logs.status ="paid", quantity, 0), 0)
									),0) as reserved_stock')
		;
	}

	public function scopeSelectGlobalStock($query, $variable)
	{
		return $query->selectcurrentstock(true)->selectonholdstock(true)->selectinventorystock(true)->selectreservedstock(true);
		;
	}

	public function scopeJoinTransactionDetailFromProduct($query, $variable)
	{
		return $query->join('varians', 'varians.product_id', '=', 'products.id')
					->join('transaction_details', 'transaction_details.varian_id', '=', 'varians.id')
		;
	}

	public function scopeJoinTransactionDetailFromVarian($query, $variable)
	{
		return $query->join('transaction_details', 'transaction_details.varian_id', '=', 'varians.id')
		;
	}

	public function scopeHavingCurrentStock($query, $variable)
	{
		return $query->havingraw('IFNULL(SUM(
									if(transactions.type ="sell", if(transaction_logs.status ="wait" OR transaction_logs.status ="paid" OR transaction_logs.status ="shipping" OR transaction_logs.status ="delivered", 0-quantity, 0), quantity)
									),0) > '.$variable)
		;
	}
}