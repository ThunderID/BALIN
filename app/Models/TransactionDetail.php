<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class TransactionDetail extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\belongsTo\HasVarianTrait;
	use \App\Models\Traits\belongsToThrough\HasProductTrait;
	use \App\Models\Traits\belongsTo\HasTransactionTrait;
	use \App\Models\Traits\Custom\HasStockTrait;
	use \App\Models\Traits\Custom\HasStatusTrait;
	use \App\Models\Traits\Custom\HasFilterTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'transaction_details';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'transaction_id'				,
											'varian_id'						,
											'quantity'						,
											'price'							,
											'discount'						,
										];

	/**
	 * Timestamp field
	 *
	 * @var array
	 */
	protected $dates				=	['created_at', 'updated_at', 'deleted_at'];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'quantity'						=> 'required|numeric',
											'price'							=> 'required|numeric',
											'discount'						=> 'required|numeric',
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
										];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden 				= [];

	
	/* ---------------------------------------------------------------------------- MUTATOR ---------------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR --------------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- FUNCTIONS -------------------------------------------------------------------------------*/

	/**
	 * return errors
	 *
	 * @return MessageBag
	 * @author 
	 **/
	public function getError()
	{
		return $this->errors;
	}

	/* ---------------------------------------------------------------------------- SCOPE -------------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ---------------------------------------------------------------------------*/

	public function scopeID($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('id', $variable);
		}

		return 	$query->where('id', $variable);
	}

	public function scopeSupplier($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('IFNULL(avg(price - discount), 0) as hb')
				->transactionbuyon(['paid','shipping','delivered'])
				->where('transactions.supplier_id', $variable)
				->groupBy('varian_id')
				;
	}

	public function scopeMostBuyByCustomer($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('varians.product_id')
				->selectraw('sum(quantity) as total_buy')
				->transactionsellon(['paid','shipping','delivered'])
				->JoinVarianFromTransactionDetail(true)
				->where('transactions.user_id', $variable)
				->groupBy('product_id')
				->orderby('total_buy', 'desc')
				;
	}

	public function scopeMostBuyByCategory($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('varians.product_id')
				->selectraw('sum(quantity) as total_buy')
				->JoinVarianFromTransactionDetail(true)
				->JoinCPFromVarian(true)
				->transactionsellon(['paid','shipping','delivered'])
				->orderby('total_buy', 'desc')
				->CategoryAncestorSuccessor($variable)
				->groupBy('product_id')
				;
	}

	public function scopeMostBuyByCustomerInCategory($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('sum(quantity) as total_buy')
				->selectraw('users.name as user_name')
				->selectraw('transactions.user_id')
				->transactionsellon(['paid','shipping','delivered'])
				->JoinVarianFromTransactionDetail(true)
				->JoinCPFromVarian(true)
				->join('users', function ($join) use($variable) 
				{
					$join->on ( 'users.id', '=', 'transactions.user_id' )
					->wherenull('users.deleted_at')
					;
				})
				->CategoryAncestorSuccessor($variable)
				->orderby('total_buy', 'desc')
				->groupBy('user_id')
				// ->groupBy('transaction_id')
				;
	}

	public function scopeFrequentBuyByCustomer($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('count(transaction_details.transaction_id) as frequent_buy')
				->selectraw('varians.product_id')
				->transactionsellon(['paid','shipping','delivered'])
				->where('transactions.user_id', $variable)
				->orderby('frequent_buy', 'desc')
				->JoinVarianFromTransactionDetail(true)
				->groupBy('product_id')
				// ->groupBy('transaction_id')
				;
	}

	public function scopeFrequentBuyByCategory($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('count(transaction_details.transaction_id) as frequent_buy')
				->selectraw('varians.product_id')
				->transactionsellon(['paid','shipping','delivered'])
				->JoinVarianFromTransactionDetail(true)
				->JoinCPFromVarian(true)
				->CategoryAncestorSuccessor($variable)
				->orderby('frequent_buy', 'desc')
				->groupBy('product_id')
				// ->groupBy('transaction_id')
				;
	}

	public function scopeFrequentBuyByCustomerInCategory($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('count(transactions.user_id) as frequent_buy')
				->selectraw('users.name as user_name')
				->selectraw('transactions.user_id')
				->transactionsellon(['paid','shipping','delivered'])
				->JoinVarianFromTransactionDetail(true)
				->JoinCPFromVarian(true)
				->join('users', function ($join) use($variable) 
				{
					$join->on ( 'users.id', '=', 'transactions.user_id' )
					->wherenull('users.deleted_at')
					;
				})
				->CategoryAncestorSuccessor($variable)
				->orderby('frequent_buy', 'desc')
				->groupBy('user_id')
				// ->groupBy('transaction_id')
				;
	}

	public function scopeMostBuy($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('sum(quantity) as total_buy')
				->selectraw('varians.product_id')
				->transactionsellon(['paid','shipping','delivered'])
				->transactiontransactat($variable)
				->JoinVarianFromTransactionDetail(true)
				->groupBy('product_id')
				->orderby('total_buy', 'desc')

				;
	}

	public function scopeFrequentBuy($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('count(transactions.id) as frequent_buy')
				->selectraw('varians.product_id')
				->transactionsellon(['paid','shipping','delivered'])
				->transactiontransactat($variable)
				->JoinVarianFromTransactionDetail(true)
				->groupBy('product_id')
				->orderby('frequent_buy', 'desc')
				// ->groupBy('transaction_id')
				;
	}

	public function scopeInventoryStock($query, $variable)
	{
		return 	$query
					->selectinventorystock(true)
					->TransactionStockOn(['wait', 'paid', 'shipping', 'delivered'])
					->first()
		;
	}

	public function scopeCountOnHoldStock($query, $variable)
	{
		return 	$query
					->selectonholdstock(true)
					->TransactionStockOn(['wait', 'paid', 'shipping', 'delivered'])
					->first()
		;
	}

	public function scopeCountCurrentStock($query, $variable)
	{
		return 	$query
					->selectcurrentstock(true)
					->TransactionStockOn(['wait', 'paid', 'shipping', 'delivered'])
					->first()
					;
		;
	}

	public function scopeCountReservedStock($query, $variable)
	{
		return 	$query
					->selectreservedstock(true)
					->TransactionStockOn(['wait', 'paid', 'shipping', 'delivered'])
					->first()
					;
		;
	}

	public function scopeCritical($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectcurrentstock(true)
				->TransactionStockOn(['wait', 'paid', 'shipping', 'delivered'])
				->HavingCurrentStock($variable)
				->orderby('current_stock', 'asc')
				->groupBy('varian_id')
				;
	}

	public function scopeCountCurrentStockByProduct($query, $variable)
	{
		return 	$query
					->selectcurrentstock(true)
					->JoinVarianFromTransactionDetail(true)
					->TransactionStockOn(['wait', 'paid', 'shipping', 'delivered'])
					->where('varians.product_id', $variable)
					->first()
					;
		;
	}

	public function scopeCountSoldItemByProduct($query, $variable)
	{
		return 	$query
					->selectsolditem(true)
					->JoinVarianFromTransactionDetail(true)
					->TransactionSellOn(['paid', 'shipping', 'delivered'])
					->first()
					;
		;
	}	
}
