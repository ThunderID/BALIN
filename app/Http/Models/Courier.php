<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'couriers';
	protected $fillable = ['name','image','status'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')

	public function Shippings()
	{
	   return $this->hasMany('\Models\Shipping');
	}
}