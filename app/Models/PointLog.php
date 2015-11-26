<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class PointLog extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\belongsTo\HasUserTrait;
	use \App\Models\Traits\morphTo\HasReferenceTrait;
	use \App\Models\Traits\hasMany\HasPointLogsTrait;
	use \App\Models\Traits\belongsTo\HasPointLogTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'point_logs';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'user_id'						,
											'point_log_id'					,
											'reference_id'					,
											'reference_type'				,
											'amount'						,
											'expired_at'					,
											'notes'							,
										];

	/**
	 * Timestamp field
	 *
	 * @var array
	 */
	protected $dates				=	['created_at', 'updated_at', 'deleted_at', 'expired_at'];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'amount'						=> 'numeric',
											'expired_at'					=> 'required|date_format:"Y-m-d H:i:s"|after:now',
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

	public function scopeDebit($query, $variable)
	{
		return 	$query->where('amount', '>', '0');
	}

	public  function scopeOnActive($query, $variable)
	{
		if(!is_array($variable))
		{
			return $query->where('expired_at', '>=', date('Y-m-d H:i:s', strtotime($variable)));
		}

		return $query->where('expired_at', '>=', date('Y-m-d H:i:s', strtotime($variable[0])))->where('expired_at', '<=', date('Y-m-d H:i:s', strtotime($variable[1])));
	}

	public  function scopeOndate($query, $variable)
	{
		if(!is_array($variable))
		{
			return $query->where('created_at', date('Y-m-d H:i:s', strtotime($variable)));
		}

		return $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($variable[0])))->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($variable[1])));
	}

	public  function scopeDownline($query, $variable)
	{
		return $query->selectraw('point_logs.*')->selectraw('count(reference_id) as downline')->ondate($variable)->ReferenceType('App\Models\User')->groupby('reference_id')->orderby('downline', 'desc');
	}

	public function scopeRangeDate($query, $start, $end)
	{
		if($start && $end)
		{
			return 	$query->where('created_at', '>=', $start)
							->where('created_at', '<=', $end)
							;
		}

		return 	$query;
	}

	public function scopeCurrentPoint($query, $variable)
	{
		return 	$query->selectraw('point_logs.*')
		->selectraw('IFNULL(SUM(point_logs.amount),0) as amount')
		->selectraw('IFNULL(SUM(point_logs.amount),0) as prev_amount')
		->selectraw('(SELECT IFNULL(SUM(plogs.amount),0) FROM point_logs as plogs join point_logs on plogs.user_id = point_logs.user_id WHERE plogs.user_id = '.$variable.' and plogs.user_id = '.$variable.' and plogs.created_at < point_logs.created_at and plogs.deleted_at is null and point_logs.deleted_at is null and plogs.expired_at >= "'.date('Y-m-d H:i:s').'" and point_logs.expired_at >= "'.date('Y-m-d H:i:s').'") as prev_amount')
		->where('point_logs.expired_at', '>=', date('Y-m-d H:i:s'))
		->userid($variable)->groupby(['point_logs.reference_type', 'point_logs.reference_id'])
		;
	}
}
