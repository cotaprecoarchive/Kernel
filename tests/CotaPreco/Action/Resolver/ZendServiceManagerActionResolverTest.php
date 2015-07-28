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
    public function throwsActionNotFoundException()
    {
        $this->setExpectedException(ActionNotFoundException::class);

        /* @var ServiceLocatorInterface|\PHPUnit_Framework_MockObject_MockObject $locator */
        $locator = $this->getMock(ServiceLocatorInterface::class);

        $locator->expects($this->once())
            ->method('has')
            ->will($this->returnValue(false));

        $resolver = new ZendServiceManagerActionResolver($locator);

        $resolver(null);
    }

    /**
     * @test
     */
    public function throwsActionNotExecutableException()
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

        $resolver(null);
    }

    /**
     * @return \callable[][]
     */
    public function provideCallables()
    {
        return [
            [
                function () {
                }
            ],
            [$this->getMock(ExecutableHttpActionInterface::class)]
        ];
    }

    /**
     * @test
     * @param callable $callable
     * @dataProvider provideCallables
     */
    public function invoke($callable)
    {
        /* @var ServiceLocatorInterface|\PHPUnit_Framework_MockObject_MockObject $serviceLocator */
        $serviceLocator = $this->getMock(ServiceLocatorInterface::class);

        $serviceLocator->expects($this->once())
            ->method('has')
            ->will($this->returnValue(true));

        $serviceLocator->expects($this->once())
            ->method('get')
            ->will($this->returnValue($callable));

        $resolver = new ZendServiceManagerActionResolver($serviceLocator);

        $this->assertTrue(is_callable($resolver(null)));
    }
}
