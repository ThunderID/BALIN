<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth, DB;

class Product extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\hasMany\HasCategoryProductTrait;
	use \App\Models\Traits\hasMany\HasPricesTrait;
	use \App\Models\Traits\hasMany\HasLablesTrait;
	use \App\Models\Traits\hasMany\HasVariansTrait;
	use \App\Models\Traits\hasManyThrough\HasTransactionDetailsTrait;
	use \App\Models\Traits\belongsToMany\HasCategoriesTrait;
	use \App\Models\Traits\morphMany\HasImagesTrait;
	use \App\Models\Traits\Custom\HasStockTrait;
	use \App\Models\Traits\Custom\HasStatusTrait;

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
											'upc'							,
											'slug'							,
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
											'upc'							=> 'required|max:255',
											'slug'							=> 'required|max:255',
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
											'price',
											'discount',
											'promo_price',
											'stock',
											'started_at',
											'label',
											'default_image'
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
		$price 						= $this->prices;//Price::productid($this->id)->ondate('now')->first();

		if(isset($price[0]))
		{
			return $price[count($this->prices)-1]->price;
		}

		return 0;
	}

	public function getDiscountAttribute($value)
	{
		if($this->promo_price==0)
		{
			return 0;
		}
	
		return $this->price - $this->promo_price;
	}

	public function getPromoPriceAttribute($value)
	{
		$price 						= $this->prices;//Price::productid($this->id)->ondate('now')->first();
		
		if(isset($price[0]))
		{
			$price 					= $price[count($this->prices)-1]->promo_price;
		}
		else
		{
			$price 					= 0;
		}

		// if(Auth::check())
		// {
		// 	$user 						= Auth::user();
		// 	$balance					= Auth::user()->balance;
		// 	if($balance > 0)
		// 	{
		// 		//count price based on balance reduce cart stuff
		// 		$transaction 			= Transaction::type('sell')->status('draft')->userid($user->id)->first();

		// 		if($transaction)
		// 		{
		// 			$cart 				= $balance - $transaction->amount;
		// 		}
		// 		else
		// 		{
		// 			$cart 				= $balance;
		// 		}

		// 		$price 					= $price - $cart;

		// 		if($price < 0)
		// 		{
		// 			return 0;
		// 		}
		// 		else
		// 		{
		// 			return $price;
		// 		}
		// 	}
		// }

		return $price;
	}

	public function getStartedAtAttribute($value)
	{
		$price 						= $this->prices;//Price::productid($this->id)->ondate('now')->first();

		if(isset($price[0]))
		{
			return date('Y-m-d H:i:s', strtotime($price[count($this->prices)-1]->started_at));
		}

		return date('Y-m-d H:i:s');
	}

	public function getLabelAttribute($value)
	{
		// $price 						= Price::productid($this->id)->ondate('now')->first();

		// if($price)
		// {
		// 	return $price->label;
		// }

		return '';
	}

	public function getStockAttribute($value)
	{
		$stock 						= TransactionDetail::CountCurrentStockByProduct($this->id);
		
		if($stock)
		{
			return $stock->current_stock;
		}

		return 0;
	}

	public function getDefaultImageAttribute($value)
	{
		$image 						= $this->images;

		if(isset($image[0]))
		{
			// return str_replace('8000', '9900', $image[0]->image_md);
			return $image[0]->image_md;
		}
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

	public function scopeSlug($query, $variable)
	{
		return 	$query->where('slug', $variable);
	}

	public function scopeUPC($query, $variable)
	{
		return 	$query->where('upc', $variable);
	}

	public function scopeNotID($query, $variable)
	{
		if(is_null($variable))
		{
			return 	$query;
		}

		if(is_array($variable))
		{
			return 	$query->whereNotIn('products.id', $variable);
		}

		return 	$query->where('products.id', '<>', $variable);
	}

	public function scopeSellable($query, $variable)
	{
		return 	$query->selectraw('products.*')
					->selectcurrentstock(true)
					->JoinTransactionDetailFromProduct(true)
					->TransactionStockOn(['wait', 'paid', 'shipping', 'delivered'])
					->HavingCurrentStock(0)
					->groupby('products.id')
					;
		;
	}

	public function scopeGlobalStock($query, $variable)
	{
		return 	$query->selectraw('products.*')
					->selectglobalstock(true)
					->JoinTransactionDetailFromProduct(true)
					->TransactionStockOn(['wait', 'paid', 'shipping', 'delivered'])
					->groupby('products.id')
					;
		;
	}

	public function scopeTotalSell($query, $variable)
	{
		return 	$query
					->select('products.*')
					->selectraw('(SELECT IFNULL(COUNT(quantity),0) FROM transaction_details join varians on transaction_details.varian_id = varians.id WHERE varians.product_id = products.id and transaction_details.deleted_at is null and varians.deleted_at is null) as selled_frequency')
					->selectraw('(SELECT IFNULL(COUNT(quantity),0) FROM transaction_details join varians on transaction_details.varian_id = varians.id WHERE varians.product_id = products.id and transaction_details.deleted_at is null and varians.deleted_at is null) as selled_stock')
					->JoinTransactionDetailFromProduct(true)
					->TransactionSellOn(['paid', 'shipping', 'delivered'])
					->groupby('products.id')
					;
	}

	public function scopeSuppliers($query, $variable)
	{
		return 	$query
					->selectraw('products.*')
					->selectraw('suppliers.name as supplier_name')
					->selectraw('suppliers.id as supplier_id')
					->JoinTransactionDetailFromProduct(true)
					->TransactionBuyOn(['paid', 'shipping', 'delivered'])
					->join('suppliers', 'suppliers.id', '=', 'transactions.supplier_id')
					->groupby('transactions.supplier_id')
					;
	}

	public function scopeHPP($query, $variable)
	{
		return 	$query
					->select('products.*')
					->selectraw('(SELECT IFNULL(avg(price),0) as total_hpp FROM transaction_details join varians on transaction_details.varian_id = varians.id WHERE varians.product_id = products.id and transaction_details.deleted_at is null and varians.deleted_at is null) as hpp')
					->JoinTransactionDetailFromProduct(true)
					->TransactionBuyOn(['paid', 'shipping', 'delivered'])
					;
	}

	public function scopeMargin($query, $variable)
	{
		return 	$query
					->hpp(true)
					->selectraw('(SELECT IF(promo_price = "0", price, promo_price) as total_price FROM products join prices on products.id = prices.id and products.deleted_at is null and prices.deleted_at is null limit 1) as current_price')
					->havingraw('`hpp` - `current_price` < '.$variable)
					->groupby('product_id')
					;
	}

}
