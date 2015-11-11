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
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('buy')->supplierid($variable);})
				->groupBy('varian_id')
				;
	}

	public function scopeMostBuyByCustomer($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('varians.product_id')
				->selectraw('sum(quantity) as total_buy')
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell')->userid($variable);})
				->orderby('total_buy', 'desc')
				->join('varians', 'varians.id', '=', 'transaction_details.varian_id')
				->groupBy('product_id')
				;
	}

	public function scopeMostBuyByCategory($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('varians.product_id')
				->selectraw('sum(quantity) as total_buy')
				->wherehas('product.categoryproduct', function($q)use($variable){$q->categoryid($variable);})
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell');})
				->orderby('total_buy', 'desc')
				->join('varians', 'varians.id', '=', 'transaction_details.varian_id')
				->groupBy('product_id')
				;
	}

	public function scopeFrequentBuyByCustomer($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('count(transaction_id) as frequent_buy')
				->selectraw('varians.product_id')
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell')->userid($variable);})
				->orderby('frequent_buy', 'desc')
				->join('varians', 'varians.id', '=', 'transaction_details.varian_id')
				->groupBy('product_id')
				// ->groupBy('transaction_id')
				;
	}

	public function scopeFrequentBuyByCategory($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('count(transaction_id) as frequent_buy')
				->selectraw('varians.product_id')
				->wherehas('product.categoryproduct', function($q)use($variable){$q->categoryid($variable);})
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell');})
				->orderby('frequent_buy', 'desc')
				->join('varians', 'varians.id', '=', 'transaction_details.varian_id')
				->groupBy('product_id')
				// ->groupBy('transaction_id')
				;
	}

	public function scopeMostBuy($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('sum(quantity) as total_buy')
				->selectraw('varians.product_id')
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell')->ondate($variable);})
				->orderby('total_buy', 'desc')
				->join('varians', 'varians.id', '=', 'transaction_details.varian_id')
				->groupBy('product_id')

				;
	}

	public function scopeFrequentBuy($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('count(transaction_id) as frequent_buy')
				->selectraw('varians.product_id')
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell')->ondate($variable);})
				->orderby('frequent_buy', 'desc')
				->join('varians', 'varians.id', '=', 'transaction_details.varian_id')
				->groupBy('product_id')
				// ->groupBy('transaction_id')
				;
	}

	public function scopeLeastBuy($query, $date)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('varians.product_id')
				->selectraw('sum(quantity) as total_buy')
				->whereDoesntHave('transaction', function($q)use($date){$q->status(['paid','shipping','delivered'])->type('sell')->where('transacted_at','>=',$date);})
				->orderby('total_buy', 'desc')
				->join('varians', 'varians.id', '=', 'transaction_details.varian_id')
				->groupBy('product_id')
				;
	}

	public function scopeCountOnHoldStock($query, $variable)
	{
		return 	$query
					->selectraw('IFNULL(SUM(quantity),0) on_hold_stock')
					->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
					->whereIn('transactions.status', ['wait'])
					->where('transactions.type', 'sell')
					->first()
					;
		;
	}

	public function scopeCountCurrentStock($query, $variable)
	{
		return 	$query
					->selectraw('IFNULL(SUM(if(transactions.type ="sell", 0-quantity, quantity)),0) current_stock')
					->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
					->wherehas('transaction', function($q){$q->status(['paid', 'shipping', 'delivered']);})
					->whereIn('transactions.type', ['sell', 'buy'])
					->first()
					;
		;
	}

	public function scopeCountReservedStock($query, $variable)
	{
		return 	$query
					->selectraw('IFNULL(SUM(quantity),0) reserved_stock')
					->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
					->whereIn('transactions.status', ['paid'])
					->where('transactions.type', 'sell')
					->first()
					;
		;
	}

	public function scopeCountBoughtStock($query, $variable)
	{
		return 	$query
					->selectraw('IFNULL(SUM(quantity),0) bought_stock')
					->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
					->whereIn('transactions.status', ['delivered'])
					->where('transactions.type', 'buy')
					->first()
					;
	}
		
	public function scopeCritical($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('IFNULL(SUM(if(transactions.type ="sell", 0-quantity, quantity)),0) stock')
				->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
				->join(DB::raw('(SELECT status, transaction_id, changed_at from transaction_logs as tlogs1 where changed_at = (SELECT MAX(changed_at) FROM transaction_logs AS tlogs2 WHERE tlogs1.transaction_id = tlogs2.transaction_id and tlogs2.deleted_at is null) and tlogs1.deleted_at is null group by transaction_id) as transaction_logs'), function ($join) use($variable) 
						{
							$join
								->on('transaction_logs.transaction_id', '=', 'transactions.id')
								->whereIn('transaction_logs.status' , ['wait', 'paid', 'shipping', 'delivered'])
								;
						})
				->whereIn('transactions.type', ['sell', 'buy'])
				->orderby('stock', 'asc')
				// ->join('varians', 'varians.id', '=', 'transaction_details.varian_id')
				->groupBy('varian_id')
				;
	}

	public function scopeCountCurrentStockByProduct($query, $variable)
	{
		return 	$query
					->selectraw('IFNULL(SUM(if(transactions.type ="sell", 0-quantity, quantity)),0) current_stock')
					->join('varians', 'varians.id', '=', 'transaction_details.varian_id')
					->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
					->join(DB::raw('(SELECT status, transaction_id, changed_at from transaction_logs as tlogs1 where changed_at = (SELECT MAX(changed_at) FROM transaction_logs AS tlogs2 WHERE tlogs1.transaction_id = tlogs2.transaction_id and tlogs2.deleted_at is null) and tlogs1.deleted_at is null group by transaction_id) as transaction_logs'), function ($join) use($variable) 
						{
							$join
								->on('transaction_logs.transaction_id', '=', 'transactions.id')
								->whereIn('transaction_logs.status' , ['wait', 'paid', 'shipping', 'delivered'])
								;
						})
					->whereIn('transactions.type', ['sell', 'buy'])
					->where('varians.product_id', $variable)
					->first()
					;
		;
	}

	public function scopeCountSoldItemByProduct($query, $variable)
	{
		return 	$query
					->selectraw('IFNULL(SUM(quantity),0) sold_item')
					->join('varians', 'varians.id', '=', 'transaction_details.varian_id')
					->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
					->join(DB::raw('(SELECT status, transaction_id, changed_at from transaction_logs as tlogs1 where changed_at = (SELECT MAX(changed_at) FROM transaction_logs AS tlogs2 WHERE tlogs1.transaction_id = tlogs2.transaction_id and tlogs2.deleted_at is null) and tlogs1.deleted_at is null group by transaction_id) as transaction_logs'), function ($join) use($variable) 
						{
							$join
								->on('transaction_logs.transaction_id', '=', 'transactions.id')
								->whereIn('transaction_logs.status' , ['paid', 'shipping', 'delivered'])
								;
						})
					->whereIn('transactions.type', ['sell'])
					->first()
					;
		;
	}	
}
