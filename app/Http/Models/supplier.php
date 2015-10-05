<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'suppliers';
	protected $fillable 			=	[
											'name',
											'phone',
											'address',
										];
	protected $rules				= 	[
											'name' 					=> 'required|max:255',
											// 'phone' 				=> 'required',
											// 'address' 			=> 'required',
										];										
	protected $errors 				=	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')


	/* --------------------------------------------- SCOPE ---------------------------------------------*/


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