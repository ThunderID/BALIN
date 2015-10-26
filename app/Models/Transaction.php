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

	use \App\Models\Traits\belongsTo\HasUserTrait;
	use \App\Models\Traits\belongsTo\HasSupplierTrait;
	use \App\Models\Traits\hasMany\HasTransactionDetailsTrait;
	use \App\Models\Traits\hasMany\HasPaymentsTrait;
	use \App\Models\Traits\hasMany\HasShipmentsTrait;
	use \App\Models\Traits\hasMany\HasPointLogsTrait;
	use \App\Models\Traits\belongsToMany\HasTransactionProductsTrait;

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
											'ref_number'					,
											'referral_code'					,
											'type'							,
											'status'						,
											'transacted_at'					,
											'unique_number'					,
											'shipping_cost'					,
											'referral_discount'				,
											'amount'						,
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
											'type'							=> 'required|in:buy,sell',
											'status'						=> 'required|in:draft,waiting,paid,shipped,delivered,canceled',
											// 'transacted_at'					=> 'required|date_format:"Y-m-d H:i:s"',
											'amount'						=> 'numeric',
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

	public function scopeStatus($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('status', $variable);
		}

		return 	$query->where('status', $variable);
	}

	public function scopeType($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('type', $variable);
		}

		return 	$query->where('type', $variable);
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
