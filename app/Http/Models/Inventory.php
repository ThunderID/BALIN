<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'inventories';
	protected $fillable = ['number_of_stock'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Product()
	{
	   return $this->belongsTo('\Models\Product');
	}
}