<?php namespace Models\Observers;

use \Validator;
use Models\category;
use Models\product;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving							
 * ---------------------------------------------------------------------- */

class category_productObserver 
{
	public function saving($model)	
	{
		$category 								= category::find($model->category_id);

		if(!category::find($model->category_id)) 
		{
			$model['errors'] 					= 'Data kategori tidak valid';
			return false;
		}

		$product 								= product::find($model->product_id);

		if(!product::find($model->product_id)) 
		{
			$model['errors'] 					= 'Data produk tidak valid';
			return false;
		}		

		return true;
	}

	public function deleting($model)
	{
		return true;
	}	
}