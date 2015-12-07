<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

class GlobalCategory extends Eloquent
{
	use SingleTableInheritanceTrait;

	use SoftDeletes;

	/**
	 * The trait used by the model.
	 *
	 * @var string
	 */

	use \App\Models\Traits\belongsTo\HasCategoryTrait;
	use \App\Models\Traits\hasMany\HasCategoriesTrait;
	use \App\Models\Traits\hasMany\HasCategoryProductTrait;
	use \App\Models\Traits\belongsToMany\HasProductsTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table 								= "categories";

	protected static $singleTableTypeField	 		= 'type';

	protected static $singleTableSubclasses 		= ['App\Models\Category', 'App\Models\Tag'];

	// protected $timestamps			= true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'category_id'					,
											'type'							,
											'path'							,
											'name'							,
											'slug'							,
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
											'type'							=> 'required|in:tag,category',
											'path'							=> 'required|max:255',
											'name'							=> 'required|max:255',
											'slug'							=> 'max:255',
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
			return 	$query->whereIn('categories.id', $variable);
		}

		return 	$query->where('categories.id', $variable);
	}
	
	public function scopeNotID($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereNotIn('id', $variable);
		}

		return 	$query->where('id','<>', $variable);
	}

	public function scopeInnerID($query, $variable)
	{
		return	$query->where(function($query) use($variable) 
			{
				foreach ($variable as $key => $value) 
				{
					$query->orwhere('categories.id', $value);
				}
			});
	}

	public function scopeName($query, $variable)
	{
		return 	$query->where('name', 'like', '%'.$variable.'%');
	}

	public function scopeType($query, $variable)
	{
		return 	$query->where('type', $variable);
	}

	public function scopeSlug($query, $variable)
	{
		if (is_array($variable))
		{
			return $query->whereIn('slug', $variable);
		}
		else
		{
			return 	$query->where('slug', $variable);
		}
	}

	public function scopeRoot($q)
	{
		return $q->where('category_id', '=', 0);
	}

	public function getIsRootAttribute()
	{
		return $this->category_id == 0;
	}
}
