<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'categories';
	protected $fillable = ['name', 'path', 'parent_id'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Product_categories()
	{
	   return $this->hasMany('\Models\Product_category');
	}
}