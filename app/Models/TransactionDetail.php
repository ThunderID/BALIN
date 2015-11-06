<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\belongsTo\HasProductTrait;
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
											'product_id'					,
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
				->groupBy('product_id')
				;
	}

	public function scopeMostBuyByCustomer($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('sum(quantity) as total_buy')
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell')->userid($variable);})
				->orderby('total_buy', 'desc')
				->groupBy('product_id')
				;
	}

	public function scopeMostBuyByCategory($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('sum(quantity) as total_buy')
				->wherehas('product.categoryproduct', function($q)use($variable){$q->categoryid($variable);})
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell');})
				->orderby('total_buy', 'desc')
				->groupBy('product_id')
				;
	}

	public function scopeFrequentBuyByCustomer($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('count(transaction_id) as frequent_buy')
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell')->userid($variable);})
				->orderby('frequent_buy', 'desc')
				->groupBy('transaction_id')
				;
	}

	public function scopeFrequentBuyByCategory($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('count(transaction_id) as frequent_buy')
				->wherehas('product.categoryproduct', function($q)use($variable){$q->categoryid($variable);})
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell');})
				->orderby('frequent_buy', 'desc')
				->groupBy('transaction_id')
				;
	}

	public function scopeMostBuy($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('sum(quantity) as total_buy')
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell')->ondate($variable);})
				->orderby('total_buy', 'desc')
				->groupBy('product_id')
				;
	}

	public function scopeFrequentBuy($query, $variable)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('count(transaction_id) as frequent_buy')
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->type('sell')->ondate($variable);})
				->orderby('frequent_buy', 'desc')
				->groupBy('transaction_id')
				;
	}

	public function scopeLeastBuy($query, $date)
	{
		return 	$query
				->selectraw('transaction_details.*')
				->selectraw('sum(quantity) as total_buy')
				->whereDoesntHave('transaction', function($q)use($date){$q->status(['paid','shipping','delivered'])->type('sell')->where('transacted_at','>=',$date);})
				->orderby('total_buy', 'desc')
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
				->selectraw('sum(quantity) as stock')
				->wherehas('transaction', function($q)use($variable){$q->status(['paid','shipping','delivered'])->ondate($variable);})
				->orderby('stock', 'asc')
				->groupBy('product_id')
				;
	}
}
