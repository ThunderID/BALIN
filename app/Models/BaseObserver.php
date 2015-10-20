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

	public function saved($model)
	{

		$class 			= $this->before($model);

		return $this->after($class, $model);
	}
	
	public function Saving($model)
	{
		$class 			= $this->before($model);

		return $this->after($class, $model);
	}

	public function before($model)
	{
		$class 			= get_class($model);
		$class2 		= explode( '\\', $class );
		$lastnameclass 	= end( $class2 );
		$class 			= str_replace('Models', 'Jobs', $class);
		$class 			= str_replace($lastnameclass, $lastnameclass.debug_backtrace()[1]['function'], $class);

		return $class;	
	}

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
	    else
	    {
	        trigger_error("Unable to load class: $class", E_USER_WARNING);
	    }

        return false;
	}
}
