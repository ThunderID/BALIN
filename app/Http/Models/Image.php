<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'images';
	protected $fillable = ['path'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Product()
	{
	   return $this->belongsTo('\Models\Product');
	}
}