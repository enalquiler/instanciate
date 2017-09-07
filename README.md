# `instanciate`

A high order function to instanciate classes passing parameters.

## Installation

```
composer require enalquiler/instanciate
```

## Usage

A simple example

```php

use DateTimeImmutable;
use function Enalquiler\Functional\instanciate;

$fn = instanciate(DateTimeImmutable::class, 'now');
$dateTimeImmutableInstance = $fn(); // Returns an instance of DateTimeImmutable class
```

A more complex example combining the [lazy middleware function](https://github.com/enalquiler/lazy-middleware), [compose function](https://github.com/igorw/compose) to compose functions, and the awesome [functional PHP library](https://github.com/lstrojny/functional-php) to build middleware pipelines using [Zend Stratigility](https://zendframework.github.io/zend-stratigility/middleware/)

```php
use Http\Factory\Diactoros\ResponseFactory;
use Zend\Diactoros\Response;
use Zend\Stratigility\MiddlewarePipe;
use function igorw\pipeline;
use function Functional\partial_right;

require_once __DIR__ . '/../vendor/autoload.php';

$pipe = new MiddlewarePipe();
$pipe->setResponsePrototype(new Response());

$lazyMiddleware = partial_right(
    pipeline(
        'Enalquiler\Functional\instanciate',
        'Enalquiler\Middleware\lazy'
    ),
    new ResponseFactory()
);

$pipe
    ->pipe($lazyMiddleware(LocaleMiddleware::class))
    ->pipe($lazyMiddleware(SessionMiddleware::class, new \PredisSessionStorage()))
    ->pipe($lazyMiddleware(RedirectionsMiddleware::class))
    ->pipe($lazyMiddleware(AdminMiddleware::class))
    ->pipe($lazyMiddleware(WebMiddleware::class))
    ->pipe($lazyMiddleware(NotFoundMiddleware::class))
;

$server = Server::createServer($app, $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
$server->listen(new Zend\Stratigility\NoopFinalHandler());
```

## Running the tests

```
php vendor/bin/phpunit
```

## Authors

* **Christian Soronellas**
* **Enalquiler Engineering**

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details 
