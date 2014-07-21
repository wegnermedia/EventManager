<?php namespace Wegnermedia\EventManager;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade {

	// Return Name of Binding in IoC Container
	protected static function getFacadeAccessor()
	{
		return "Wegnermedia\EventManager\Manager";
	}

}