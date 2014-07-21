# Laravel Event Manager Service

This Package gives you an easy way to raise and dispatch events.

## Installation

Per usual, install Commander through Composer.

```js
"require": {
    "wegnermedia/event-manager": "dev-master"
}
```

Next, add the facade `app/config/app.php`.

```php
'aliases' => [
    'EventManager' => 'Wegnermedia\EventManager\Facade'
]
```

And now build something awesome.

## Usage

`app/controllers/CartController.php`

```php
<?php

class CartController extends ShopController {

	/**
	 * Add Item to Cart.
	 *
	 * @return Response
	 */
	public function addItem()
	{
		$inputs = Input::all();

		// Validation goes here ...

		$command = new AddItemToCartCommand($inputs);

		$result = Commander::execute($command);

		EventManager::dispatch();

		// ... create the Response
	}
}
```

`app/Shop/Cart/AddItemToCartCommandHandler.php`

```php
<?php

use Wegnermedia\Commander\CommandHandlerInterface;

class AddItemToCartCommandHandler implements CommandHandlerInterface {

	/**
	 * Handle the command
	 *
	 * @return mixed
	 */
	public function handle($command)
	{
		// some awesome stuff ...

		// Raise and event with the Namespace of "Shop"
		// Event::listen('whenShop*', ... );
		EventManager::raise( new AddingItemToCartWasSuccessfulEvent($cart, $item), 'Shop' )

		// ... create the Response
	}
}

```

## Sometimes you may want to look into the stack

```php
	$stack = EventManager::stack();
```

Done!
