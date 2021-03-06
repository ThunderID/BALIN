<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

use Exception;

class Price extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\belongsTo\HasProductTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'prices';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'product_id'					,
											'price'							,
											'promo_price'					,
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
											'price'							=> 'required|numeric',
											'promo_price'					=> 'numeric',
											'started_at'					=> 'required|date_format:"Y-m-d H:i:s"',
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

		return 	$query->where('started_at', '<=', $started_at)->orderBy('started_at', 'desc');
	}

	public function scopeSort($query, $variable)
	{
		$tmp 	= explode('-', $variable);

		switch ($tmp[0]) 
		{
			case 'price':
				return $query->orderBy('prices.price',$tmp[1]);
				break;
			case 'promo':
				return $query->orderBy('prices.promo_price',$tmp[1]);
				break;
			case 'startedat':
				return $query->orderBy('prices.started_at',$tmp[1]);
				break;
			default:
				return $query;
				break;
		}
	}
}
