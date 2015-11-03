<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\belongsTo\HasSupplierTrait;
	use \App\Models\Traits\belongsTo\HasUserTrait;
	use \App\Models\Traits\belongsTo\HasVoucherTrait;
	use \App\Models\Traits\hasMany\HasTransactionDetailsTrait;
	use \App\Models\Traits\hasMany\HasTransactionLogsTrait;
	use \App\Models\Traits\hasOne\HasPaymentTrait;
	use \App\Models\Traits\hasOne\HasShipmentTrait;
	use \App\Models\Traits\belongsToMany\HasTransactionProductsTrait;
	use \App\Models\Traits\morphMany\HasPointLogsTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'transactions';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'user_id'						,
											'supplier_id'					,
											'voucher_id'					,
											'ref_number'					,
											'type'							,
											'transact_at'					,
											'unique_number'					,
											'shipping_cost'					,
											'voucher_discount'				,
										];
	/**
	 * Timestamp field
	 *
	 * @var array
	 */
	protected $dates				=	['created_at', 'updated_at', 'deleted_at', 'transact_at'];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'ref_number'					=> 'required',
											'type'							=> 'required|in:buy,sell',
											'transact_at'					=> 'required|date_format:"Y-m-d H:i:s"',
											'unique_number'					=> 'numeric',
											'shipping_cost'					=> 'numeric',
											'voucher_discount'				=> 'numeric',
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
											'amount',
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

	public function getAmountAttribute($value)
	{
		$amount 						= 0;
		foreach ($this->transactiondetails as $key => $value) 
		{
			$amount 					= $amount + (($value->price - $value->discount) * $value->quantity); 
		}

		foreach ($this->pointlogs as $key => $value) 
		{
			$amount 					= $amount + $value->amount; 
		}

		$amount 						= $amount + $this->shipping_cost - $this->voucher_discount - $this->unique_number;

		return $amount;
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

	public function scopeType($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('type', $variable);
		}

		return 	$query->where('type', $variable);
	}

	public  function scopeOndate($query, $variable)
	{
		if(!is_array($variable))
		{
			return $query->where('transact_at', date('Y-m-d H:i:s', strtotime($variable)));
		}

		return $query->where('transact_at', '>=', date('Y-m-d H:i:s', strtotime($variable[0])))->where('transact_at', '<=', date('Y-m-d H:i:s', strtotime($variable[1])));
	}

	public  function scopeTransactionProcessed($query)
	{
		return $query
			->where(function ($q) {
			    $q->where('status', 'paid')
			        ->orWhere('status',  'delivered')
			        ->orWhere('status',  'shipped');
				});
	}

	public  function scopeTransactionWaiting($query)
	{
		return $query->where('status', 'waiting');
	}	
}
