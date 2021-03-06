<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionLog extends Eloquent
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
	protected $table				= 'transaction_logs';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'transaction_id'				,
											'status'						,
											'changed_at'					,
											'notes'							,
										];

	/**
	 * Timestamp field
	 *
	 * @var array
	 */
	protected $dates				=	['created_at', 'updated_at', 'deleted_at', 'changed_at'];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'status'						=> 'required|in:cart,wait,paid,packed,shipping,delivered,canceled,abandoned',
											'changed_at'					=> 'required|date_format:"Y-m-d H:i:s"',
											'notes'							=> 'required_if:status,delivered',
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

	public function scopeCurrentStatus($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('status', $variable)->groupBy('transaction_id')->orderby('created_at', 'desc');
		}

		return 	$query->where('status', $variable)->groupBy('transaction_id')->orderby('created_at', 'desc');
	}
}
