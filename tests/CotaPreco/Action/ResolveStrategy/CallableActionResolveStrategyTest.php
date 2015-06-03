<?php

namespace CotaPreco\Action\ResolveStrategy;

use CotaPreco\Action\ExecutableHttpActionInterface;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 * @coversDefaultClass CotaPreco\Action\ResolveStrategy\CallableActionResolveStrategy
 */
class CallableActionResolveStrategyTest extends TestCase
{
    /**
     * @var CallableActionResolveStrategy
     */
    private $strategy;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->strategy = new CallableActionResolveStrategy();
    }

    /**
     * @return callable
     */
    private function emptyFunction()
    {
        return function() {
        };
    }

    /**
     * @return array
     */
    public function provideActions()
    {
        return [
            [false, false],
            [true, false],
            [null, false],
            ['', false],
            [0, false],
            [new \stdClass(), false],
            [[], false],
            [$this->emptyFunction(), true]
        ];
    }

    /**
     * @dataProvider provideActions
     * @param string $action
     * @param bool   $canResolve
     * @test
     */
    public function canResolve($action, $canResolve)
    {
        $this->assertSame($canResolve, $this->strategy->canResolve($action));
    }

    /**
     * @test
     */
    public function resolveReturnsExecutableHttpAction()
    {
        $resolved = $this->strategy->resolve($this->emptyFunction());

        $this->assertInstanceOf(ExecutableHttpActionInterface::class, $resolved);
    }
}
