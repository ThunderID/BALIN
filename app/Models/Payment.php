<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\belongsTo\HasTransactionTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'payments';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'transaction_id'				,
											'method'						,
											'destination'					,
											'account_name'					,
											'account_number'				,
											'ondate'						,
											'amount'						,
										];

	/**
	 * Timestamp field
	 *
	 * @var array
	 */
	protected $dates				=	['created_at', 'updated_at', 'deleted_at', 'ondate'];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'method'						=> 'required|max:255',
											'destination'					=> 'required|max:255',
											'account_name'					=> 'required|max:255',
											'account_number'				=> 'required|max:255',
											'ondate'						=> 'required|date_format:"Y-m-d H:i:s"',
											'amount'						=> 'required|numeric',
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

	public function scopeAmount($query, $variable)
	{
		return 	$query->where('amount', $variable);
	}

	public function scopeSort($query, $variable)
	{
		$tmp 	= explode('-', $variable);

		switch ($tmp[0]) 
		{
			case 'name':
				return $query->orderBy('payments.account_name',$tmp[1]);
				break;
			case 'ondate':
				return $query->orderBy('payments.ondate',$tmp[1]);
				break;
			default:
				return $query;
				break;
		}
	}
}
