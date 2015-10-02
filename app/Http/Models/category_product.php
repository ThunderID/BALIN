<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category_Product extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'categories_products';

	protected $fillable 			=	[
										];
	protected $rules				= 	[
										];										
	protected $errors 				=	[];


	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')

	public function category()
	{
	   return $this->belongsTo('\Models\category', 'category_id');
	}		

	public function product()
	{
	   return $this->belongsTo('\Models\product', 'product_id');
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