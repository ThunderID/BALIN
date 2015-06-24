<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'inventories';
	protected $fillable 			=	[
											'number_of_stock'
										];
	protected $rules				= 	[
											'number_of_stock' 			=> 'required'
										];
	protected $errors 				=	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Product()
	{
	   return $this->belongsTo('\Models\Product');
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