<?php

namespace CotaPreco\Action\Resolver;

use CotaPreco\Action\ActionResolverInterface;
use CotaPreco\Action\Exception\ActionNotExecutableException;
use CotaPreco\Action\Exception\ActionNotFoundException;
use CotaPreco\Action\ExecutableHttpActionInterface;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class ResolveStrategyActionResolverAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function canResolveReturnsFalse()
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

        $this->assertFalse($adapter->canResolve(null));
        $this->assertFalse($adapter->canResolve(''));
        $this->assertFalse($adapter->canResolve(''));
        $this->assertTrue($adapter->canResolve(''));
    }

    /**
     * @test
     */
    public function canResolve()
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
     * @test
     */
    public function resolveReturnsResolvedAction()
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
