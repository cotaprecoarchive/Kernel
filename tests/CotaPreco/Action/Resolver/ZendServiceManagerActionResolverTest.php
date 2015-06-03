<?php

namespace CotaPreco\Action\Resolver;

use CotaPreco\Action\Exception\ActionNotExecutableException;
use CotaPreco\Action\Exception\ActionNotFoundException;
use CotaPreco\Action\ExecutableHttpActionInterface;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class ZendServiceManagerActionResolverTest extends TestCase
{
    /**
     * @test
     */
    public function resolveThrowsActionNotFound()
    {
        $this->setExpectedException(ActionNotFoundException::class);

        /* @var ServiceLocatorInterface|\PHPUnit_Framework_MockObject_MockObject $serviceLocator */
        $serviceLocator = $this->getMock(ServiceLocatorInterface::class);

        $serviceLocator->expects($this->once())
            ->method('has')
            ->will($this->returnValue(false));

        $resolver = new ZendServiceManagerActionResolver($serviceLocator);

        $resolver->resolve(null);
    }

    /**
     * @test
     */
    public function resolveThrowsNotExecutableException()
    {
        $this->setExpectedException(ActionNotExecutableException::class);

        /* @var ServiceLocatorInterface|\PHPUnit_Framework_MockObject_MockObject $serviceLocator */
        $serviceLocator = $this->getMock(ServiceLocatorInterface::class);

        $serviceLocator->expects($this->once())
            ->method('has')
            ->will($this->returnValue(true));

        $serviceLocator->expects($this->once())
            ->method('get')
            ->will($this->returnValue(new \stdClass()));

        $resolver = new ZendServiceManagerActionResolver($serviceLocator);

        $resolver->resolve(null);
    }

    /**
     * @test
     */
    public function resolveReturnsExecutableHttpAction()
    {
        $executableHttpAction = $this->getMock(ExecutableHttpActionInterface::class);

        /* @var ServiceLocatorInterface|\PHPUnit_Framework_MockObject_MockObject $serviceLocator */
        $serviceLocator = $this->getMock(ServiceLocatorInterface::class);

        $serviceLocator->expects($this->once())
            ->method('has')
            ->will($this->returnValue(true));

        $serviceLocator->expects($this->once())
            ->method('get')
            ->will($this->returnValue($executableHttpAction));

        $resolver = new ZendServiceManagerActionResolver($serviceLocator);

        $this->assertInstanceOf(
            ExecutableHttpActionInterface::class,
            $resolver->resolve(null)
        );
    }
}
