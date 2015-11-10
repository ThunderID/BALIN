<?php namespace App\Models\Traits\belongsToMany;

trait HasCategoriesTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasCategoriesTraitConstructor()
	{
		//
	}

	/* ------------------------------------------------------------------- RELATIONSHIP TO SERVICE -------------------------------------------------------------------*/

	public function Categories()
	{
		return $this->belongsToMany('App\Models\Category', 'categories_products');
	}

	public function scopeCategoriesName($query, $variable)
	{
		return $query->whereHas('categories', function($q)use($variable){$q->name($variable);});
	}
}