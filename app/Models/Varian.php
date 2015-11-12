<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Varian extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\hasMany\HasTransactionDetailsTrait;
	use \App\Models\Traits\belongsToMany\HasTransactionsTrait;
	use \App\Models\Traits\belongsTo\HasProductTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'varians';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'product_id'					,
											'size'							,
											'sku'							,
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
											'size'							=> 'required|max:255',
											'sku'							=> 'required|max:255',
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
											'stock',
										];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden 				= [];

	
	/* ---------------------------------------------------------------------------- MUTATOR ---------------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR --------------------------------------------------------------------------------*/
	
	public function getStockAttribute($value)
	{
		$stock 						= TransactionDetail::varianid($this->id)->CountCurrentStock(true);
		
		if($stock)
		{
			return $stock->current_stock;
		}

		return 0;
	}

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
	public function scopeGlobalStock($query, $variable)
	{
		return 	$query->selectraw('varians.*')
					->selectraw('IFNULL(SUM(
									if(transactions.type ="sell", if(transaction_logs.status ="wait" OR transaction_logs.status ="paid" OR transaction_logs.status ="shipping" OR transaction_logs.status ="delivered", 0-quantity, 0), quantity)
									),0) as current_stock')
					->selectraw('IFNULL(SUM(
									if(transactions.type ="sell", if(transaction_logs.status ="wait" OR transaction_logs.status ="paid", quantity, 0), 0)
									),0) as on_hold_stock')
					->selectraw('IFNULL(SUM(
									if(transactions.type ="sell", if(transaction_logs.status ="shipping" OR transaction_logs.status ="delivered", 0-quantity, 0), quantity)
									),0) as inventory_stock')
					->selectraw('IFNULL(SUM(
									if(transactions.type ="sell", if(transaction_logs.status ="paid", quantity, 0), 0)
									),0) as reserved_stock')
					->selectraw('IFNULL(SUM(
									if(transactions.type ="sell", if(transaction_logs.status ="wait" OR transaction_logs.status ="paid", 0-quantity, 0), quantity)
									),0) as bought_stock')
					->join('transaction_details', 'transaction_details.varian_id', '=', 'varians.id')
					->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
					->join(DB::raw('(SELECT status, transaction_id, changed_at from transaction_logs as tlogs1 where changed_at = (SELECT MAX(changed_at) FROM transaction_logs AS tlogs2 WHERE tlogs1.transaction_id = tlogs2.transaction_id and tlogs2.deleted_at is null) and tlogs1.deleted_at is null group by transaction_id) as transaction_logs'), function ($join) use($variable) 
						{
							$join
								->on('transaction_logs.transaction_id', '=', 'transactions.id')
								->whereIn('transaction_logs.status' , ['wait', 'paid', 'shipping', 'delivered'])
								;
						})
					->whereIn('transactions.type', ['sell', 'buy'])
					->groupby('varians.id')
					;
		;
	}

	/* ---------------------------------------------------------------------------- QUERY BUILDER ---------------------------------------------------------------------------*/

	public function scopeID($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('id', $variable);
		}

		return 	$query->where('id', $variable);
	}

	public function scopeSize($query, $variable)
	{
		return 	$query->where('size', $variable);
	}
}
