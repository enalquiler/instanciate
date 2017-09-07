<?php

declare(strict_types=1);

namespace Enalquiler\Functional;

use Closure;
use InvalidArgumentException;

function instanciate(string $class, ...$args): Closure
{
    if (!class_exists($class)) {
        throw new InvalidArgumentException(sprintf('Class "%s" not found', $class));
    }
    
    return function () use ($class, $args) {
        return new $class(...$args);
    };
}
