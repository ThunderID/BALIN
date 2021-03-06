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
	use \App\Models\Traits\Custom\HasStockTrait;
	use \App\Models\Traits\Custom\HasStatusTrait;

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

	/* ---------------------------------------------------------------------------- QUERY BUILDER ---------------------------------------------------------------------------*/

	public function scopeID($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('id', $variable);
		}

		return 	$query->where('id', $variable);
	}

	public function scopeNotID($query, $variable)
	{
		if(is_null($variable))
		{
			return 	$query;
		}

		if(is_array($variable))
		{
			return 	$query->whereNotIn('varians.id', $variable);
		}

		return 	$query->where('varians.id', '<>', $variable);
	}

	public function scopeSize($query, $variable)
	{
		return 	$query->where('size', $variable);
	}

	public function scopeSKU($query, $variable)
	{
		return 	$query->where('sku', $variable);
	}

	public function scopeGlobalStock($query, $variable)
	{
		return 	$query->selectraw('varians.*')
					->selectglobalstock(true)
					->JoinTransactionDetailFromVarian(true)
					->TransactionStockOn(['wait', 'paid', 'packed', 'shipping', 'delivered'])
					->groupby('varians.id')
					;
		;
	}

	public function scopeLeftGlobalStock($query, $variable)
	{
		return 	$query->selectraw('varians.*')
					->selectglobalstock(true)
					->LeftJoinTransactionDetailFromVarian(true)
					->LeftJoinTransaction(true)
					->LeftTransactionLogStatus(['wait', 'paid', 'packed', 'shipping', 'delivered'])
					->groupby('varians.id')
					;
		;
	}

	public function scopeQuantityInCart($query, $variable)
	{
		return 	$query->selectraw('varians.*')
					->selectstockincart(true)
					->JoinTransactionDetailFromVarian(true)
					->TransactionStockOn('cart')
					->groupby('varians.id')
					;
		;
	}

	public function scopeCustomers($query, $variable)
	{
		return 	$query
					->selectraw('varians.*')
					->selectraw('count(quantity) as total_buy')
					->selectraw('users.name as customer_name')
					->selectraw('users.id as customer_id')
					->JoinTransactionDetailFromVarian(true)
					->TransactionSellOn(['paid', 'shipping', 'delivered'])
					->join('users', function ($join) use($variable) 
					{
						$join->on ( 'users.id', '=', 'transactions.user_id' )
						->wherenull('users.deleted_at')
						;
					})
					->groupby('transactions.user_id')
					;
	}
}
