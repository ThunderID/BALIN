<?php namespace App\Models\Traits\hasMany;

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
		return $this->hasMany('App\Models\Category');
	}

	public function scopeHasCategories($query, $variable)
	{
		return $query->whereHas('categories', function($q)use($variable){$q;});
	}
}