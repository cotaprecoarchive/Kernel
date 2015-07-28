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
        $action = new ResolveableActionRoute('POST', '/', \stdClass::class);

        $this->assertSame(\stdClass::class, $action->getDefault('action'));
        $this->assertSame('POST', $action->getMethods()[0]);
        $this->assertSame('/', $action->getPath());
    }

    /**
     * @test
     */
    public function supportsCallable()
    {
        $emptyFunction = function() {};

        $action = new ResolveableActionRoute('POST', '/', $emptyFunction);

        $this->assertSame($emptyFunction, $action->getDefault('action'));
        $this->assertSame('POST', $action->getMethods()[0]);
        $this->assertSame('/', $action->getPath());
    }
}
