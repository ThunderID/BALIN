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
	use \App\Models\Traits\hasMany\HasProductAttributesTrait;
	use \App\Models\Traits\hasMany\HasProductImagesTrait;
	use \App\Models\Traits\hasMany\HasPricesTrait;
	use \App\Models\Traits\hasMany\HasDiscountsTrait;
	use \App\Models\Traits\hasMany\HasTransactionDetailsTrait;
	use \App\Models\Traits\belongsToMany\HasTransactionsTrait;
	use \App\Models\Traits\belongsToMany\HasCategoriesTrait;

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

	public function scopeCountOnHoldStock($query, $variable)
	{
		return 	$query
					->selectraw('sum((SELECT quantity FROM transaction_details WHERE transaction_details.product_id = products.id and transaction_details.deleted_at is null)) as on_hold_stock')
					->wherehas('transaction', function($q){$q->status(['draft', 'waiting'])->type('sell')})
					;
		;
	}

	public function scopeCountReservedStock($query, $variable)
	{
		return 	$query
					->selectraw('sum((SELECT quantity FROM transaction_details WHERE transaction_details.product_id = products.id and transaction_details.deleted_at is null)) as reserved_stock')
					->wherehas('transaction', function($q){$q->status(['paid'])->type('sell')})
					;
		;
	}

	public function scopeCountBoughtStock($query, $variable)
	{
		return 	$query
					->selectraw('sum((SELECT quantity FROM transaction_details WHERE transaction_details.product_id = products.id and transaction_details.deleted_at is null)) as bought_stock')
					->wherehas('transaction', function($q){$q->status('delivered')->type('buy')})
					;
		;
	}
}
