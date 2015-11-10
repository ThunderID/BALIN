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
											'started_at'						=> 'date_format:"Y-m-d H:i:s"'/*|after: - 1 second'*/,
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
											'slider'
										];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden 				= [];

	
	/* ---------------------------------------------------------------------------- MUTATOR ---------------------------------------------------------------------------------*/

	public function getSliderAttribute($value)
	{
		if($this->images()->count())
		{
			return $this->images[0]->thumbnail;
		}

		return 'https://browshot.com/static/images/not-found.png';
	}	
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
		$variable = ['url', 'logo', 'facebook_url', 'twitter_url', 'email', 'phone', 'address', 'bank_information'];
		return $query->join(DB::raw('(SELECT tlogs1.type as typee, tlogs1.id as id2, tlogs1.started_at as start from tmp_store_settings as tlogs1 where tlogs1.started_at = (SELECT MAX(tlogs2.started_at) FROM tmp_store_settings AS tlogs2 WHERE tlogs1.id = tlogs2.id and tlogs2.deleted_at is null) and tlogs1.deleted_at is null group by id) as tmp_store_settings2'), function ($join) use($variable) 
			{
				$join
					->on('tmp_store_settings2.id2', '=', 'tmp_store_settings.id')
					->whereIn('tmp_store_settings.type', $variable)
					;
			});
	}

	public function scopeStorePage($query, $variable)
	{
		$variable = ['about_us', 'why_join', 'term_and_condition'];
		return $query->join(DB::raw('(SELECT tlogs1.type as typee, tlogs1.id as id2, tlogs1.started_at as start from tmp_store_settings as tlogs1 where tlogs1.started_at = (SELECT MAX(tlogs2.started_at) FROM tmp_store_settings AS tlogs2 WHERE tlogs1.id = tlogs2.id and tlogs2.deleted_at is null) and tlogs1.deleted_at is null group by id) as tmp_store_settings2'), function ($join) use($variable) 
			{
				$join
					->on('tmp_store_settings2.id2', '=', 'tmp_store_settings.id')
					->whereIn('tmp_store_settings.type', $variable)
					;
			});
	}

	public function scopePolicies($query)
	{
		$variable = ['expired_cart', 'expired_paid', 'expired_shipped', 'expired_point', 'referral_royalty', 'invitation_royalty', 'limit_unique_number', 'expired_link_duration', 'first_quota', 'downline_purchase_bonus', 'downline_purchase_bonus_expired', 'downline_purchase_quota_bonus', 'voucher_point_expired', 'welcome_gift'];
		return $query->join(DB::raw('(SELECT tlogs1.type as typee, tlogs1.id as id2, tlogs1.started_at as start from tmp_store_settings as tlogs1 where tlogs1.started_at = (SELECT MAX(tlogs2.started_at) FROM tmp_store_settings AS tlogs2 WHERE tlogs1.id = tlogs2.id and tlogs2.deleted_at is null) and tlogs1.deleted_at is null group by id) as tmp_store_settings2'), function ($join) use($variable) 
			{
				$join
					->on('tmp_store_settings2.id2', '=', 'tmp_store_settings.id')
					->whereIn('tmp_store_settings.type', $variable)
					;
			});

		// return 	$query->whereIn('type', $variable )->orderByRaw(DB::raw('started_at desc, type'))->take(count($variable));
	}
}