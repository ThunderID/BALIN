<?php namespace App\Models\Traits\Custom;

use DB;

trait HasFilterTrait 
{

	/**
	 * boot
	 *
	 * @return void
	 * @author 
	 **/

	function HasFilterTraitConstructor()
	{
		//
	}

	public function scopeJoinCPFromVarian($query, $variable)
	{
		return $query
		 ->join('categories_products', function ($join) use($variable) 
			 {
                                    $join->on ( 'categories_products.product_id', '=', 'varians.product_id' )
                                    ->wherenull('categories_products.deleted_at')
                                    ;
			})
		;
	}

	public function scopeJoinVarianAndCategory($query, $variable)
	{
		if(!is_array($variable))
		{
			return $query
			 ->join('categories_products', function ($join) use($variable) 
			 {
                                    $join->on( 'categories_products.product_id', '=', 'varians.product_id' )
                                    ->where('categories_products.category_id', '=', $variable )
                                    ->wherenull('categories_products.deleted_at')
                                    ;
			})
			;
		}
		else
		{
			return $query
			 ->join('categories_products', function ($join) use($variable) 
			 {
                                    $join->on ( 'categories_products.product_id', '=', 'varians.product_id' )
                                    ->whereIn('categories_products.category_id', $variable)
                                    ->wherenull('categories_products.deleted_at')
                                    ;
			})
			;
		}
	}
}