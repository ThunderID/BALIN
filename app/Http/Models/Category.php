<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'categories';
	protected $fillable 			=	[
											'path',
											'name',
											'parent_id'
										];
	protected $rules				= 	[
											'name' 					=> 'required|max:255',
										];										
	protected $errors 				=	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')

	public function category()
	{
	   return $this->belongsTo('\Models\category','parent_id');
	}

	public function categories()
	{
	   return $this->hasMany('\Models\category','parent_id');
	}		

	public function categoryProducts()
	{
	   return $this->hasMany('\Models\category_product','category_id');
	}	

	public function products()
	{
	   return $this->belongsToMany('\Models\product','categories_products');
	}		
		
	// public function products()
	// {
	//    return $this->hasMany('\Models\product');
	// }

	/* --------------------------------------------- SCOPE ---------------------------------------------*/
	public function scopeFindCategory($query, $variable)
	{
		return $query
			->where('parent_id', '<>', $variable)
		;
	}

	public function scopeGetName($query)
	{
		return $query
			->select('categories.id', 'name');
		;
	}


	/* ---------------------------------------------------------------------------- ERRORS ----------------------------------------------------------------------------*/
	/**
	 * return errors
	 *
	 * @return MessageBag
	 * @author 
	 **/
	function getError()
	{
		return $this->errors;
	}		
}