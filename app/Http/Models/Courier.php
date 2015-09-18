<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Eloquent {
	use  SoftDeletes;

	protected $guarded 				= array();
	protected $table 				= 'couriers';
	protected $fillable				= 	[
											'name',
											'image',
											'status'
										];
	protected $rules				= 	[
											'name' 						=> 'required|max:255',
											'image' 					=> 'max:255',
											'status' 					=> 'required|integer'
										];													  
	protected $errors 				= 	[];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')

	public function courierBranches()
	{
	   return $this->hasMany('\Models\courierBranches');
	}

	/* ---------------------------------------------------------------------------- SCOPE -------------------------------------------------------------------------------*/

	public function scopeId($query, $variable)
	{
		return $query->where('status', '=' , 1);
	}

	public function scopeStatus($query, $variable)
	{
		return $query->where('status', '=' , $variable);
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