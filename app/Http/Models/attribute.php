<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class attribute extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'attributes';

	protected $fillable 			=	[
											'attribute',
											'value'
										];
	protected $rules				= 	[
											'attribute' 			=> 'required|max:255',
											'value' 				=> 'required|max:255'
										];										
	protected $errors 				=	[];


	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')

	public function product()
	{
	   return $this->belongsTo('\Models\product');
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