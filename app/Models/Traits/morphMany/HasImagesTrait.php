<?php namespace App\Models\Traits\morphMany;

trait HasImagesTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasImagesTraitConstructor()
	{
		//
	}

	public function Images()
	{
		return $this->morphMany('App\Models\Image', 'imageable')->orderby('created_at','desc');
	}

	public function scopeDefaultImage($query, $variable)
	{
		return $query->whereHas('images', function($q)use($variable){$q->default(true);})->with(['images' => function($q)use($variable){$q->default(true);}]);
	}
}