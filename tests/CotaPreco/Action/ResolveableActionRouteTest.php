<?php

namespace CotaPreco\Action;

use PHPUnit_Framework_TestCase as TestCase;
use stdClass;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 * @coversDefaultClass CotaPreco\Action\ResolveableActionRoute
 * @covers ::__construct
 */
class ResolveableActionRouteTest extends TestCase
{
    public function testItSupportsFqcn()
    {
        $action = new ResolveableActionRoute('GET', '/', stdClass::class);

        $this->assertSame(stdClass::class, $action->getDefault('action'));
        $this->assertSame('GET', $action->getMethods()[0]);
        $this->assertSame('/', $action->getPath());
    }

    public function testItSupportsCallable()
    {
        $emptyFunction = function() {
        };

        $action = new ResolveableActionRoute('GET', '/', $emptyFunction);

        $this->assertSame($emptyFunction, $action->getDefault('action'));
        $this->assertSame('GET', $action->getMethods()[0]);
        $this->assertSame('/', $action->getPath());
    }
}
