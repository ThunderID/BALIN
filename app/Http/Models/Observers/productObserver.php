<?php namespace Models\Observers;

use \Validator;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving		
 * 	Deleting						
 * ---------------------------------------------------------------------- */

class CourierObserver 
{
	public function saving($model)
	{
		$validator 				= Validator::make($model['attributes'], $model['rules']);

		if ($validator->passes())
		{
			return true;
		}
		else
		{
			$model['errors'] 	= $validator->errors();

			return false;
		}
	}

	public function deleting($model)
	{
		if($model->Images->count() && $model->Prices->count() $model->Inventories->count() && $model->Categories->count() && $model->Transaction_details->count())
		{
			$model['errors'] 	= ['Tidak dapat menghapus data Produk'];

			return false;
		}

		return true;
	}

}