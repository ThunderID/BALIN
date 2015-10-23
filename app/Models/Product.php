<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\hasMany\HasStocksTrait;
	use \App\Models\Traits\hasMany\HasCategoryProductTrait;
	use \App\Models\Traits\hasMany\HasPricesTrait;
	use \App\Models\Traits\hasMany\HasDiscountsTrait;
	use \App\Models\Traits\hasMany\HasTransactionDetailsTrait;
	use \App\Models\Traits\belongsToMany\HasTransactionsTrait;
	use \App\Models\Traits\belongsToMany\HasCategoriesTrait;
	use \App\Models\Traits\morphMany\HasImagesTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'products';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'name'							,
											'sku'							,
											'slug'							,
											'is_new'						,
											'description'					,
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
											'name'							=> 'required|max:255',
											'sku'							=> 'required|max:255',
											'slug'							=> 'required|max:255',
											'is_new'						=> 'boolean',
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
											'price',
											'promo_price',
											'discount',
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

	public function getPriceAttribute($value)
	{
		$price 						= Price::productid($this->id)->ondate('now')->first();

		if($price)
		{
			return $price->price;
		}

		return 0;
	}

	public function getDiscountAttribute($value)
	{
		if($this->promo_price!=0)
		{
			return $this->price - $this->promo_price;
		}

		return 0;
	}

	public function getPromoPriceAttribute($value)
	{
		$discount 					= Price::productid($this->id)->ondate('now')->first();
		
		if($discount)
		{
			return $discount->promo_price;
		}

		return 0;
	}

	public function getStockAttribute($value)
	{
		$stock 						= Stock::productid($this->id)->ondate('now')->first();

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

	public function scopeName($query, $variable)
	{
		return 	$query->where('name', 'like', '%'.$variable.'%');
	}

	public function scopeCountOnHoldStock($query, $variable)
	{
		return 	$query
					->selectraw('(SELECT IFNULL(SUM(quantity),0) FROM transaction_details WHERE transaction_details.product_id = products.id and transaction_details.deleted_at is null) as on_hold_stock')
					->wherehas('transactions', function($q){$q->status(['draft', 'waiting'])->type('sell');})
					->first()
					;
		;
	}

	public function scopeCountReservedStock($query, $variable)
	{
		return 	$query
					->selectraw('(SELECT IFNULL(SUM(quantity),0) FROM transaction_details WHERE transaction_details.product_id = products.id and transaction_details.deleted_at is null) as reserved_stock')
					->wherehas('transactions', function($q){$q->status(['paid'])->type('sell');})
					->first()
					;
		;
	}

	public function scopeCountBoughtStock($query, $variable)
	{
		return 	$query
					->selectraw('(SELECT IFNULL(SUM(quantity),0) FROM transaction_details WHERE transaction_details.product_id = products.id and transaction_details.deleted_at is null) as bought_stock')
					->wherehas('transactions', function($q){$q->status('delivered')->type('buy');})
					->first()
					;
	}

	public function scopeTotalSell($query, $variable)
	{
		return 	$query
					->select('products.*')
					->selectraw('(SELECT IFNULL(COUNT(quantity),0) FROM transaction_details WHERE transaction_details.product_id = products.id and transaction_details.deleted_at is null) as selled_frequency')
					->selectraw('(SELECT IFNULL(COUNT(quantity),0) FROM transaction_details WHERE transaction_details.product_id = products.id and transaction_details.deleted_at is null) as selled_stock')
					->wherehas('transactions', function($q){$q->status(['paid','shipped','delivered'])->type('sell');})
					// ->first()
					;
	}
}
