<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'categories';
	protected $fillable 			=	[
											'name',
											'path', 
											'parent_id'
										];
	protected $rules				= 	[
											'name' 						=> 'required|max:255',
											'path' 						=> 'required|max:255',
											'parent_id' 				=> 'required'
										];										
	protected $errors 				= 	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Products()
	{
	   return $this->belongsToMany('\Models\Product', 'product_categories', 'product_id', 'category_id')
	   		->WithPivot('category_id', 'product_id');
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