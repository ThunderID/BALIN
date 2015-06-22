<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'prices';
	protected $fillable = ['price', 'promo_price', 'start_date', 'end_date'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Product()
	{
	   return $this->belongsTo('\Models\Product');
	}
}