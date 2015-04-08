<?php

namespace CotaPreco\Action\Resolver;

use CotaPreco\Action\Exception\ActionNotExecutableException;
use CotaPreco\Action\Exception\ActionNotFoundException;
use CotaPreco\Action\ExecutableHttpActionInterface;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 * @coversDefaultClass CotaPreco\Action\Resolver\ZendServiceManagerActionResolver
 * @covers ::resolve
 * @covers ::__construct
 */
class ZendServiceManagerActionResolverTest extends TestCase
{
    public function testResolveThrowsActionNotFound()
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

    public function testResolveThrowsNotExecutableException()
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

    public function testResolveReturnsExecutableHttpAction()
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
        $action   = $resolver->resolve(null);

        $this->assertInstanceOf(ExecutableHttpActionInterface::class, $action);
    }
}
