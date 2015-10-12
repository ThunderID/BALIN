<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Policy extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'tmp_policies';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'type'							,
											'value'							,
											'started_at'					,
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
											'type'								=> 'required|max:255',
											'value'								=> 'required|max:255',
											'started_at'						=> 'required|date_format:"Y-m-d H:i:s"',
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

	public function scopeGetTTL($query, $variable)
	{
		if(is_array($variable))
		{
			throw new Exception('Date must not be array.');
		}

		return 	$query->type('expired_link_duration')->ondate($variable);
	}

	public function scopeGetExpiredDraft($query, $variable)
	{
		if(is_array($variable))
		{
			throw new Exception('Date must not be array.');
		}

		return 	$query->type('expired_draft')->ondate($variable);
	}	

	public function scopeOnDate($query, $variable)
	{
		if(is_array($variable))
		{
			throw new Exception('Date must not be array.');
		}
		else
		{
			$started_at 				= date('Y-m-d H:i:s', strtotime($variable));
		}

		return 	$query->where('started_at', '<=', $started_at)->orderBy('started_at', 'asc');
	}
}
