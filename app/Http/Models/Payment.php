<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'payments';
	protected $fillable 			=	[
											'name',
											'bank',
											'account_number', 
											'date'
										];
	protected $rules				= 	[
											'name' 					=> 'required|max:255',
											'bank' 					=> 'required|max:255',
											'account_number' 		=> 'required',
											'date' 					=> 'required|date'
										];										
	protected $errors 				=	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function transaction()
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