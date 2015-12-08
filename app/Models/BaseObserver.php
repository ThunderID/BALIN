<?php namespace App\Models;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Validator, Event;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving						
 * ---------------------------------------------------------------------- */

class BaseObserver
{
    use DispatchesJobs;

	public function Creating($model)
	{
		$class 			= $this->before($model);

		return $this->after($class, $model);
	}

	public function Created($model)
	{
		$class 			= $this->before($model);

		return $this->after($class, $model);
	}	

	public function Saving($model)
	{
		$validator 				= Validator::make($model['attributes'], $model['rules'], (isset($model['message']) ? $model['message'] : []));

		if (!$validator->passes())
		{
			$model['errors'] 	= $validator->errors();

			return false;
		}


		$class 			= $this->before($model);

		return $this->after($class, $model);
	}

	public function Saved($model)
	{
		$class 			= $this->before($model);

		return $this->after($class, $model);
	}
	
	public function Updating($model)
	{
		$class 			= $this->before($model);

		return $this->after($class, $model);
	}

	public function Updated($model)
	{
		$class 			= $this->before($model);

		return $this->after($class, $model);
	}

	public function Deleting($model)
	{
		$class 			= $this->before($model);

		return $this->after($class, $model);
	}

	public function Deleted($model)
	{
		$class 			= $this->before($model);

		return $this->after($class, $model);
	}

	public function Restoring($model)
	{
		$class 			= $this->before($model);

		return $this->after($class, $model);
	}

	public function Restored($model)
	{
		$class 			= $this->before($model);

		return $this->after($class, $model);
	}

	//get class name
	public function before($model)
	{
		$class 			= get_class($model);
		$class2 		= explode( '\\', $class );
		$lastnameclass 	= end( $class2 );
		$class 			= str_replace('Models', 'Jobs\\Models', $class);
		$class 			= str_replace($lastnameclass, $lastnameclass.'\\'.$lastnameclass.debug_backtrace()[1]['function'], $class);

		return $class;	
	}

	//check if class exists
	public function after($class, $model)
	{
		if (class_exists($class) && get_parent_class($class) == 'App\Jobs\Job') 
		{
	        $result                         = $this->dispatch(new $class($model));

	        if($result->getStatus()=='error')
	        {
	        	$model['errors']			= $result->getErrorMessage();

	        	return false;
	        }
	        else
	        {
	        	return true;
	        }
	    }
	    elseif(!class_exists($class))
	    {
	        // trigger_error("Unable to load class: $class", E_USER_WARNING);
	    	return true;
	    }
	    else
	    {
	        trigger_error("Unable to load class: $class", E_USER_WARNING);
	    }

        return false;
	}
}
