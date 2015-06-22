<?php namespace Models;
use Validator;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Eloquent {
	use  SoftDeletes;

	protected $guarded = array();
	protected $table = 'products';
	protected $fillable = ['SKU','name','description', 'slug'];
	protected $errors = [];

	/* --------------------------------------------- RELATIONSHIP ---------------------------------------------*/
	//jamak untuk return jamak ('s')
		
	public function Images()
	{
	   return $this->hasMany('\Models\Image');
	}

	public function Prices()
	{
	   return $this->hasMany('\Models\Price');
	}	

	public function Inventories()
	{
	   return $this->hasMany('\Models\Inventory');
	}	

	public function Product_categories()
	{
	   return $this->hasMany('\Models\Product_category');
	}	

	public function Transaction_details()
	{
	   return $this->hasMany('\Models\Transaction_detail');
	}		
}