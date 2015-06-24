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
		if($model->Shippings->count())
		{
			$model['errors'] 	= ['Tidak dapat menghapus data Kurir yang memiliki data transaksi'];

			return false;
		}

		return true;
	}

}