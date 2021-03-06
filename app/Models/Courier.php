<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\hasMany\HasShipmentsTrait;
	use \App\Models\Traits\hasMany\HasShippingCostsTrait;
	use \App\Models\Traits\morphMany\HasImagesTrait;
	use \App\Models\Traits\morphMany\HasAddressesTrait;


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'couriers';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'name'							,
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
											'name'							=> 'required|max:255',
										];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[
											'logo',
											'address'
										];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden 				= [];

	
	/* ---------------------------------------------------------------------------- MUTATOR ---------------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR --------------------------------------------------------------------------------*/

	public function getLogoAttribute($value)
	{
		$image 						= $this->images;
		if(isset($image[count($image)-1]))
		{
			return $image[count($image)-1]->image_md;
		}

		return 'https://browshot.com/static/images/not-found.png';
	}

	public function getAddressAttribute()
	{

		if(isset($this->addresses[0]))
		{
			$address 					= $this->addresses[0]['attributes'];
		}
		else
		{
			$address 					= NULL;
		}

		return $address;
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
		if(is_array($variable))
		{
			return 	$query->whereNotIn('id', $variable);
		}

		return 	$query->where('id','<>', $variable);
	}

	public function scopeName($query, $variable)
	{
		return 	$query->where('name', 'like', '%'.$variable.'%');
	}

	public function scopeSort($query, $variable)
	{
		$tmp 	= explode('-', $variable);

		switch ($tmp[0]) 
		{
			case 'name':
				return $query->orderBy('couriers.name',$tmp[1]);
				break;
			default:
				return $query;
				break;
		}
	}
}
