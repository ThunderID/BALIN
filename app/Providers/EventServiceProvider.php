<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = 
	[
		// 'eloquent.saving: App\\Models\\Transaction'			=>	['App\Listeners\TransactionSaving'],
		'eloquent.saved: App\\Models\\Transaction'			=>	['App\Listeners\TransactionSaved'],
		'eloquent.saved: App\\Models\\Payment'				=>	['App\Listeners\PaymentSaved'],
		'eloquent.saved: App\\Models\\Shipment'				=>	['App\Listeners\ShipmentSaved'],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		//
	}
}
