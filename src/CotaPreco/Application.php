<?php

namespace CotaPreco;

use CotaPreco\Action\ActionResolverInterface;
use CotaPreco\Action\ControllerResolverActionResolverAdapter;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class Application implements ApplicationHttpKernelInterface
{
    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @var ActionResolverInterface
     */
    private $actionResolver;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param RouteCollection          $routeCollection
     * @param ActionResolverInterface  $actionResolver
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        RouteCollection          $routeCollection,
        ActionResolverInterface  $actionResolver,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        $this->routeCollection = $routeCollection;
        $this->actionResolver  = $actionResolver;
        $this->eventDispatcher = $eventDispatcher ?: new EventDispatcher();
    }

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param RouteCollection          $routeCollection
     */
    private function injectRouteListener(
        EventDispatcherInterface $eventDispatcher,
        RouteCollection          $routeCollection
    ) {
        $context = new RequestContext();
        $matcher = new UrlMatcher($routeCollection, $context);

        $eventDispatcher->addSubscriber(new RouterListener($matcher));
    }

    /**
     * {@inheritDoc}
     */
    public function handle(Request $request)
    {
        $this->injectRouteListener(
            $this->eventDispatcher,
            $this->routeCollection
        );

        $resolver = $this->actionResolver;
        $kernel   = new HttpKernel(
            $this->eventDispatcher,
            new ControllerResolverActionResolverAdapter($resolver)
        );

        $response = $kernel->handle($request);
        $response->send();

        $kernel->terminate($request, $response);
    }
}
