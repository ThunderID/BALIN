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
		return $this->belongsToMany('App\Models\Category', 'categories_products', 'category_id', 'product_id');
	}

	public function scopeCategoriesName($query, $variable)
	{
		return $query->whereHas('categories', function($q)use($variable){$q->name($variable);});
	}

	public function Tags()
	{
		return $this->belongsToMany('App\Models\Tag', 'categories_products', 'category_id', 'product_id');
	}

	public function scopeTagsName($query, $variable)
	{
		return $query->whereHas('tags', function($q)use($variable){$q->name($variable);});
	}

	public function GlobalCategories()
	{
		return $this->belongsToMany('App\Models\GlobalCategory', 'categories_products', 'category_id', 'product_id');
	}
}