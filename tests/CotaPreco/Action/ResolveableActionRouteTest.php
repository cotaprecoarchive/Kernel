<?php

namespace CotaPreco\Action;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class ResolveableActionRouteTest extends TestCase
{
    /**
     * @test
     */
    public function supportsFqcn()
    {
        $action = new ResolveableActionRoute('GET', '/', \stdClass::class);

        $this->assertSame(\stdClass::class, $action->getDefault('action'));
        $this->assertSame('GET', $action->getMethods()[0]);
        $this->assertSame('/', $action->getPath());
    }

    /**
     * @test
     */
    public function supportsCallable()
    {
        $emptyFunction = function() {
        };

        $action = new ResolveableActionRoute('GET', '/', $emptyFunction);

        $this->assertSame($emptyFunction, $action->getDefault('action'));
        $this->assertSame('GET', $action->getMethods()[0]);
        $this->assertSame('/', $action->getPath());
    }
}
