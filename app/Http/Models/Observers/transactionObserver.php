<?php namespace Models\Observers;

use \Validator;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving		
 * 	Deleting						
 * ---------------------------------------------------------------------- */

class transactionObserver 
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
		if($model->Transaction_details->count() && $model->Customer->count()  && $model->Shipping->count() && $model->Payment->count())
		{
			$model['errors'] 	= ['Tidak dapat menghapus data transaksi'];

			return false;
		}

		return true;
	}

}