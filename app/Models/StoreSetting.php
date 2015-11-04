<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class StoreSetting extends Eloquent
{
	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */
	use \App\Models\Traits\morphMany\HasImagesTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'tmp_store_settings';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'type'								,
											'value'								,
											'started_at'						,
										];

	/**
	 * Timestamp field
	 *
	 * @var array
	 */
	protected $dates				=	['created_at', 'updated_at', 'deleted_at', 'started_at'];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'type'								=> 'required|max:255',
											'value'								=> 'required',
											'started_at'						=> 'date_format:"Y-m-d H:i:s"|after: - 1 second',
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
			return $query->where('started_at', '<=', date('Y-m-d H:i:s', strtotime($variable)))->orderBy('started_at', 'desc');
		}

		return $query->where('started_at', '>=', date('Y-m-d H:i:s', strtotime($variable[0])))->where('started_at', '<=', date('Y-m-d H:i:s', strtotime($variable[1])))->orderBy('started_at', 'asc');
	}

	public function scopeStoreInfo($query, $variable)
	{
		return 	$query->type(['url', 'logo', 'facebook_url', 'twitter_url', 'email', 'phone', 'address', 'bank_information'])->orderByRaw(DB::raw('started_at, type'));
	}

	public function scopeStorePage($query, $variable)
	{
		return 	$query->type(['about_us', 'why_join', 'term_and_condition'])->orderByRaw(DB::raw('started_at, type'));
	}

	public function scopePolicies($query)
	{
		return 	$query->whereIn('type', ['expired_cart', 'expired_paid', 'expired_shipped', 'expired_point', 'referral_royalty', 'invitation_royalty', 'limit_unique_number', 'expired_link_duration', 'first_quota'] );
	}
}