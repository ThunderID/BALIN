<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_category extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'product_categories';
	protected $fillable 			=	[];
	protected $rules				= 	[];
	protected $errors 				=	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Product()
	{
	   return $this->belongsTo('\Models\Product');
	}

	public function Category()
	{
	   return $this->belongsTo('\Models\Category');
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