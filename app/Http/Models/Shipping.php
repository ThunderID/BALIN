<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Eloquent {
	use  SoftDeletes;

	protected $guarded 			= array();
	protected $table 			= 'shippings';
	protected $fillable 		=	[
										'name',
										'code',
										'address', 
										'zip_code', 
										'phone', 
										'date'
									];
	protected $rules			= 	[
										'name' 						=> 'required|max:255',
										'code' 						=> 'max:255',
										'address' 					=> 'required',
										'zip_code' 					=> 'required|max:255',
										'phone' 					=> 'required|max:255',
										'date' 						=> 'date'
									];										
	protected $errors 			=	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function courierBranch()
	{
	   return $this->belongsTo('\Models\courierBranches');
	}

	public function Transaction()
	{
	   return $this->belongsTo('\Models\Transaction');
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