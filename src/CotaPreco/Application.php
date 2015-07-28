<?php

/*
 * Copyright (c) 2015 Cota Preço
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

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
     * {@inheritdoc}
     */
    public function __invoke(Request $request)
    {
        $context = new RequestContext();
        $context->fromRequest($request);

        $this->eventDispatcher->addSubscriber(
            new RouterListener(
                new UrlMatcher($this->routeCollection, $context)
            )
        );

        $kernel = new HttpKernel(
            $this->eventDispatcher,
            new ControllerResolverActionResolverAdapter($this->actionResolver)
        );

        $response = $kernel->handle($request);
        $response->send();

        $kernel->terminate($request, $response);
    }
}
