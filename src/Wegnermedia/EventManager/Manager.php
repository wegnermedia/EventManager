<?php namespace Wegnermedia\EventManager;

use Illuminate\Events\Dispatcher;

/**
* Event Manager
*/
class Manager
{
	/**
	 * Stack of pending Events
	 *
	 * @var array
	 **/
	protected $stack = array();

	/**
	 * Instance of Laravels Event Dispatcher
	 *
	 * @var object
	 **/
	protected $events;

	function __construct(Dispatcher $events)
	{
		$this->events = $events;
	}

	/**
	 * Put Event to Stack
	 *
	 * @return this
	 **/
	public function raise($event, $prefix = null)
	{
		$name = $this->generateName($event, $prefix);

		$this->stack[] = array(
			'name'  	=> $name,
			'payload'	=> $event
		);

		return $this;
	}

	/**
	 * Dispatch Event Stack
	 *
	 * @return this
	 **/
	public function dispatch()
	{
		// Proceed Only if there are Events
		// In Stack Array
		if ( empty($this->stack) ) return $this;

		// Cache Events
		$events = $this->stack;

		// Reset the Stack
		$this->stack = array();

		// Fire, fire, fire ...
		foreach($events as $event)
		{
			$this->events->fire($event['name'], $event['payload']);
		}

		// Done ...
		return $this;
	}

	/**
	 * Returns the current Stack
	 *
	 * @return array
	 **/
	public function stack()
	{
		return $this->stack;
	}

	/**
	 * Generate Event Name with optional prefix
	 *
	 * @return string
	 **/
	protected function generateName($event, $prefix = null)
	{
		// Namespaced Events will get a Naming Prefix later
		// to easy Group Events
		$prefix = ( is_string($prefix) ) ? $prefix : null;

		// Generate the Name for the Event
		$name = class_basename($event);

		// Cut off 'Event'
		$name = preg_replace("/Event$/ui", "", $name);

		// Prefix with 'when' + Prefix
		return 'when' . $prefix . $name;
	}


}