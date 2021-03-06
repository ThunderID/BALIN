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
		return $this->belongsToMany('App\Models\Category', 'categories_products', 'product_id', 'category_id');
	}

	public function scopeCategoriesID($query, $variable)
	{
		return $query->whereHas('categories', function($q)use($variable){$q->id($variable);});
	}

	public function scopeCategoriesName($query, $variable)
	{
		return $query->whereHas('categories', function($q)use($variable){$q->name($variable);});
	}

	public function scopeCategoriesSlug($query, $variable)
	{
		return $query->whereHas('categories', function($q)use($variable){$q->slug($variable);});
	}

	public function Tags()
	{
		return $this->belongsToMany('App\Models\Tag', 'categories_products', 'product_id', 'category_id');
	}

	public function scopeTagsID($query, $variable)
	{
		return $query->whereHas('tags', function($q)use($variable){$q->id($variable);});
	}

	public function scopeTagsSlug($query, $variable)
	{
		return $query->whereHas('tags', function($q)use($variable){$q->slug($variable);});
	}

	public function scopeTagging($query, $variable)
	{
		if (is_array($variable))
		{
			foreach ($variable as $key => $value) 
			{
				$query = $query->tagsslug($value);
			}
		}
		else
		{
			$query = $query->tagsslug($variable);
		}
		return $query;
	}

	public function scopeTagsName($query, $variable)
	{
		return $query->whereHas('tags', function($q)use($variable){$q->name($variable);});
	}

	public function GlobalCategories()
	{
		return $this->belongsToMany('App\Models\GlobalCategory', 'categories_products', 'product_id', 'category_id');
	}
}