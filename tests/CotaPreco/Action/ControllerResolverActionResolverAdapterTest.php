<?php

namespace CotaPreco\Action;

use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class ControllerResolverActionResolverAdapterTest extends TestCase
{
    /**
     * @var Request
     */
    private $emptyRequest;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->emptyRequest = Request::create('/');
    }

    /**
     * @test
     */
    public function getControllerReturnsNull()
    {
        $this->emptyRequest->attributes = new ParameterBag();

        /* @var ActionResolverInterface $resolver */
        $resolver = $this->getMock(ActionResolverInterface::class);

        $adapter = new ControllerResolverActionResolverAdapter($resolver);

        $this->assertNull($adapter->getController($this->emptyRequest));
    }

    /**
     * @test
     */
    public function getControllerReturnsCallable()
    {
        $action = $this->getMock(ExecutableHttpActionInterface::class);

        /* @var \PHPUnit_Framework_MockObject_MockObject|ActionResolverInterface $resolver */
        $resolver = $this->getMock(ActionResolverInterface::class);

        $resolver->expects($this->once())
            ->method('__invoke')
            ->will($this->returnValue($action));

        $request = $this->emptyRequest;

        $request->attributes = new ParameterBag([
            'action' => $action
        ]);

        $adapter = new ControllerResolverActionResolverAdapter($resolver);

        $controller = $adapter->getController($request);

        $this->assertTrue(is_callable($controller));
    }

    /**
     * @test
     */
    public function getArguments()
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
