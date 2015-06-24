<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'products';
	protected $fillable 			=	[
											'SKU',
											'name',
											'description', 
											'slug'
										];
	protected $rules				= 	[
											'SKU' 					=> 'required|max:255',
											'name' 					=> 'required|max:255'
										];										
	protected $errors 				=	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Images()
	{
	   return $this->hasMany('\Models\Image');
	}

	public function Prices()
	{
	   return $this->hasMany('\Models\Price');
	}	

	public function Inventories()
	{
	   return $this->hasMany('\Models\Inventory');
	}	

	public function Categories()
	{
	   return $this->belongsToMany('\Models\Category', 'product_categories', 'category_id', 'product_id')
	   		->WithPivot('category_id', 'product_id');
	}	

	public function Transaction_details()
	{
	   return $this->hasMany('\Models\Transaction_detail');
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