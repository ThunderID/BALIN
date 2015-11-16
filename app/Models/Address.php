<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\morphTo\HasAddressTrait;
	use \App\Models\Traits\Custom\HasStatusTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'addresses';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'owner_id'						,
											'owner_type'					,
											'phone'							,
											'address'						,
											'zipcode'						,
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
											'owner_id'						=> 'required',
											'owner_type'					=> 'required',
											'phone'							=> 'required',
											'address'						=> 'required',
											'zipcode'						=> 'required',
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
											// 'Address',
										];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden 				= [];

	
	/* ---------------------------------------------------------------------------- MUTATOR ---------------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR --------------------------------------------------------------------------------*/

	// public function getAddressAttribute($value)
	// {
	// 	if($this->address()->count())
	// 	{
	// 		return $this->address;
	// 	}

	// 	return false;
	// }

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

	public function scopeOlderShipmentByCustomer($query, $variable)
	{
		return $query->join('shipments', 'shipments.address_id', '=', 'addresses.id')
					->join('transactions', 'transactions.id', '=', 'shipments.transaction_id')
					->transactionlogstatus(['wait', 'paid', 'shipping', 'delivered'])
					->extendtransactiontype('sell')
					->where('transactions.user_id', $variable)
				;
	}
}
