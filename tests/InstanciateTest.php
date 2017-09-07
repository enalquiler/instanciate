<?php

declare(strict_types=1);

namespace Enalquiler\Functional;

use Closure;
use PHPUnit\Framework\TestCase;
use function Enalquiler\Functional\instanciate;

final class InstanciateTest extends TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function givenANonExistingClass_ItThrowsAnException(): void
    {
        instanciate('test');
    }
    
    /** @test */
    public function itCanInstanciateClasses(): void
    {
        $fn = instanciate(ClassWithoutArguments::class);
        
        assertInstanceOf(Closure::class, $fn);
        assertInstanceOf(ClassWithoutArguments::class, $fn());
        
        $fn = instanciate(ClassWithArguments::class, 'foo', 1);
        assertInstanceOf(ClassWithArguments::class, $fn());
    }
}

class ClassWithoutArguments
{
}

class ClassWithArguments
{
    public function __construct(string $foo, int $bar)
    {
    }
}
