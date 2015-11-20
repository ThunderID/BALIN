<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auditor extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\morphTo\HasTableTrait;
	use \App\Models\Traits\belongsTo\HasUserTrait;


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'auditors';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'user_id'						,
											'table_id'						,
											'table_type'					,
											'ondate'						,
											'type'							,
											'event'							,
											'action'						,
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
											'ondate'						=> 'date_format:"Y-m-d H:i:s"',
											'event'							=> 'required',
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
											'address',
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
			return 	$query->whereIn('auditors.id', $variable);
		}

		return 	$query->where('auditors.id', $variable);
	}

	public function scopeType($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('auditors.type', $variable);
		}

		return 	$query->where('auditors.type', $variable);
	}

	public  function scopeOndate($query, $variable)
	{
		if(!is_array($variable))
		{
			return $query->where('ondate', date('Y-m-d H:i:s', strtotime($variable)));
		}

		return $query->where('ondate', '>=', date('Y-m-d H:i:s', strtotime($variable[0])))->where('ondate', '<=', date('Y-m-d H:i:s', strtotime($variable[1])));
	}

	public  function scopeStaff($query, $variable)
	{
		return $query->wherehas('user', function($q){$q->role(['admin','staff','store_manager']);});
	}


	public  function scopeVoucherType($query, $variable)
	{
		return $query->selectraw('auditors.*')
					->join('tmp_vouchers', 'tmp_vouchers.id', '=', 'table_id')
					->whereIn('tmp_vouchers.type', $variable);
	}
}
