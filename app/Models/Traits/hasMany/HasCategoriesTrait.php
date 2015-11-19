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

	public function Tags()
	{
		return $this->hasMany('App\Models\Tag', 'category_id');
	}

	public function scopeHasTags($query, $variable)
	{
		return $query->whereHas('tags', function($q)use($variable){$q;});
	}
}