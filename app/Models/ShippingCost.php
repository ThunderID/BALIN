<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingCost extends Eloquent
{

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\belongsTo\HasCourierTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'shipping_costs';

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'courier_id'					,
											'start_postal_code'				,
											'end_postal_code'				,
											'started_at'					,
											'cost'							,
										];

	/**
	 * Timestamp field
	 *
	 * @var array
	 */
	protected $dates				=	['started_at','created_at', 'updated_at', 'deleted_at'];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'start_postal_code'				=> 'required|numeric',
											'end_postal_code'				=> 'required|numeric',
											'cost'							=> 'required|numeric',
											'started_at'					=> 'required|date_format:"Y-m-d H:i:s"|after:now',
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

	public function scopeNotID($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereNotIn('id', $variable);
		}

		return 	$query->where('id','<>', $variable);
	}

	public function scopeShippingCost($query, $start, $end)
	{
		return $query->where(function($query) use($start, $end) {
			$query->where(function($query) use($start, $end) {
				$query->where('start_postal_code','<=',$start)
					->where('end_postal_code','>=',$end);
				})
			->orwhere(function($query) use($start, $end) {
				$query->where('end_postal_code','>=', $start)
					->where('end_postal_code','<=',$end);
				})
			->orwhere(function($query) use($start, $end) {
				$query->where('start_postal_code','>=', $start)
					->where('start_postal_code','<=',$end);
				})
			->orwhere(function($query) use($start, $end) {
				$query->where('start_postal_code','<=', $start)
					->where('end_postal_code','>=',$end);
				})
		;});
	}	

	public function scopePostalCode($query, $variable)
	{
		return 	$query->whereraw('start_postal_code <= ' . $variable . '<= end_postal_code')
						->orderby('started_at', 'desc');
	}

	public function getError()
	{
		return $this->errors;
	}	
}
