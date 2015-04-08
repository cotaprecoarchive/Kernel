<?php

namespace CotaPreco\Action\Resolver;

use CotaPreco\Action\ActionResolverInterface;
use CotaPreco\Action\Exception\ActionNotExecutableException;
use CotaPreco\Action\Exception\ActionNotFoundException;
use CotaPreco\Action\ExecutableHttpActionInterface;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 * @coversDefaultClass CotaPreco\Action\Resolver\ResolveStrategyActionResolverAdapter
 * @covers ::__construct
 */
class ResolveStrategyActionResolverAdapterTest extends TestCase
{
    /**
     * @covers ::canResolve
     */
    public function testCanResolveReturnsFalse()
    {
        /* @var ActionResolverInterface|\PHPUnit_Framework_MockObject_MockObject $resolver */
        $resolver = $this->getMock(ActionResolverInterface::class);

        $resolver->expects($this->at(0))
            ->method('resolve')
            ->will($this->throwException(new ActionNotFoundException()));

        $resolver->expects($this->at(1))
            ->method('resolve')
            ->will($this->throwException(new ActionNotExecutableException()));

        $resolver->expects($this->at(2))
            ->method('resolve')
            ->will($this->throwException(new \Exception()));

        $adapter = new ResolveStrategyActionResolverAdapter($resolver);

        $this->assertFalse($adapter->canResolve(null)); // ! is_string
        $this->assertFalse($adapter->canResolve(''));   // at(0)
        $this->assertFalse($adapter->canResolve(''));   // at(1)
        $this->assertTrue($adapter->canResolve(''));    // at(2)
    }

    /**
     * @covers ::canResolve
     */
    public function testCanResolveReturnsTrue()
    {
        /* @var ExecutableHttpActionInterface $action */
        $action = $this->getMock(ExecutableHttpActionInterface::class);

        /* @var ActionResolverInterface|\PHPUnit_Framework_MockObject_MockObject $resolver */
        $resolver = $this->getMock(ActionResolverInterface::class);

        $resolver->expects($this->once())
            ->method('resolve')
            ->will($this->returnValue($action));

        $adapter = new ResolveStrategyActionResolverAdapter($resolver);
        $canResolve = $adapter->canResolve('');

        $this->assertTrue($canResolve);
    }

    /**
     * @covers ::resolve
     */
    public function testResolveReturnsResolvedAction()
    {
        $action = $this->getMock(ExecutableHttpActionInterface::class);

        /* @var ActionResolverInterface|\PHPUnit_Framework_MockObject_MockObject $resolver */
        $resolver = $this->getMock(ActionResolverInterface::class);

        $resolver->expects($this->once())
            ->method('resolve')
            ->will($this->returnValue($action));

        $action = $resolver->resolve(null);

        $this->assertInstanceOf(ExecutableHttpActionInterface::class, $action);
    }
}
