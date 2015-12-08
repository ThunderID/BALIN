<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\hasMany\HasTransactionsTrait;
	use \App\Models\Traits\hasMany\HasQuotaLogsTrait;
	use \App\Models\Traits\belongsTo\HasUserTrait;
	use \App\Models\Traits\morphMany\HasPointLogsTrait;
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'tmp_vouchers';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'user_id'						,
											'code'							,
											'type'							,
											'value'							,
											'started_at'					,
											'expired_at'					,
										];

	/**
	 * Timestamp field
	 *
	 * @var array
	 */
	protected $dates				=	['created_at', 'updated_at', 'deleted_at', 'expired_at', 'started_at'];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'code'							=> 'required|max:255|min:8',
											'type'							=> 'required|max:255',
											'value'							=> 'numeric',
											// 'started_at'					=> 'date_format:"Y-m-d H:i:s"|after:now',
											'expired_at'					=> 'date_format:"Y-m-d H:i:s"|after:now',
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
											'quota',
										];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden 				= [];

	
	/* ---------------------------------------------------------------------------- MUTATOR ---------------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR --------------------------------------------------------------------------------*/
	
	public function getQuotaAttribute($value)
	{
		if(isset($this->current_quota))
		{
			$quota					= $this->current_quota;
		}
		else
		{
			$quota					= QuotaLog::voucherid($this->id)->sum('amount');
		}	
			
		return $quota;
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

	public function scopeNotID($query, $variable)
	{
		if(is_null($variable))
		{
			return 	$query;
		}

		if(is_array($variable))
		{
			return 	$query->whereNotIn('id', $variable);
		}

		return 	$query->where('id', '<>', $variable);
	}

	public function scopeCode($query, $variable)
	{
		return 	$query->where('code', $variable);
	}

	public function scopeType($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('type', $variable);
		}

		return 	$query->where('type', $variable);
	}

	public function scopeNotType($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereNotIn('type', $variable);
		}

		return 	$query->where('type', '<>', $variable);
	}

	public function scopeOnDate($query, $variable)
	{
		if(is_array($variable))
		{
			$started_at 	= date('Y-m-d H:i:s', strtotime($variable[0]));
			$expired_at 	= date('Y-m-d H:i:s', strtotime($variable[1]));
			return $query->where('started_at', '<=', $started_at)
						->where('expired_at', '>=', $expired_at)
						;
		}
		else
		{
			$ondate 	= date('Y-m-d H:i:s', strtotime($variable));
			return $query->where('started_at', '<=', $ondate)
						->where('expired_at', '>=', $ondate)
						;
		}
	}

	public function scopeCurrentQuota($query, $variable)
	{
		return 	$query
					->selectraw('tmp_vouchers.*')
					->selectraw('IFNULL(sum(quota_logs.amount),0) as current_quota')
					->leftjoin('quota_logs', function($join)
					{
						$join->on('quota_logs.voucher_id', '=', 'tmp_vouchers.id')
						->wherenull('quota_logs.deleted_at')
						;
					})
					->groupby('tmp_vouchers.id')
					;
	}

	public function scopeSort($query, $variable)
	{
		$tmp 	= explode('-', $variable);

		switch ($tmp[0]) 
		{
			case 'type':
				return $query->orderBy('tmp_vouchers.type',$tmp[1]);
				break;
			case 'quota':
				return $query->orderBy('current_quota',$tmp[1]);
				break;
			case 'startedat':
				return $query->orderBy('tmp_vouchers.started_at',$tmp[1]);
				break;
			default:
				return $query;
				break;
		}
	}
}
