<?php

namespace CotaPreco\Action;

use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 * @coversDefaultClass CotaPreco\Action\ControllerResolverActionResolverAdapter
 * @covers ::__construct
 */
class ControllerResolverActionResolverAdapterTest extends TestCase
{
    /**
     * @var Request
     */
    private $emptyRequest;

    protected function setUp()
    {
        $this->emptyRequest = Request::create('/');
    }

    /**
     * @covers ::getController
     */
    public function testGetControllerReturnsNull()
    {
        $attributes = $this->getMock(ParameterBag::class);
        $attributes->expects($this->once())
            ->method('has')
            ->will($this->returnValue(false));

        $request = $this->emptyRequest;
        $request->attributes = $attributes;

        /* @var ActionResolverInterface $resolver */
        $resolver = $this->getMock(ActionResolverInterface::class);

        $adapter = new ControllerResolverActionResolverAdapter($resolver);

        $this->assertNull($adapter->getController($request));
    }

    /**
     * @covers ::getController
     */
    public function testGetControllerReturnsCallable()
    {
        $executableHttpAction = $this->getMock(ExecutableHttpActionInterface::class);
        $executableHttpAction->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(true));

        /* @var ActionResolverInterface $resolver */
        $resolver = $this->getMock(ActionResolverInterface::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->will($this->returnValue($executableHttpAction));

        $attributes = $this->getMock(ParameterBag::class);

        $attributes->expects($this->once())
            ->method('has')
            ->will($this->returnValue(true));

        $attributes->expects($this->once())->method('get');

        $request = $this->emptyRequest;
        $request->attributes = $attributes;

        $adapter = new ControllerResolverActionResolverAdapter($resolver);
        $controller = $adapter->getController($request);

        $this->assertTrue(is_callable($controller));
        $this->assertTrue($controller($request));
    }

    /**
     * @covers ::getArguments
     */
    public function testGetArgumentsAlwaysReturnRequest()
    {
        /* @var ActionResolverInterface $resolver */
        $resolver = $this->getMock(ActionResolverInterface::class);

        $adapter = new ControllerResolverActionResolverAdapter($resolver);

        /* @var Request[] $arguments */
        $arguments = $adapter->getArguments($this->emptyRequest, null);

        $this->assertCount(1, $arguments);
        $this->assertInstanceOf(Request::class, $arguments[0]);
    }
}