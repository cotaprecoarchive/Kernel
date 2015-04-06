<?php

use CotaPreco\Action\ResolveableActionRoute as R;
use CotaPreco\Action\Resolver\ResolverChain;
use CotaPreco\Action\ResolveStrategy\CallableActionResolveStrategy;
use CotaPreco\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class MyApplication extends Application
{
    /**
     * @return ResolverChain
     */
    private function getActionResolver()
    {
        $resolver = new ResolverChain();
        $resolver->addResolveStrategy(new CallableActionResolveStrategy());

        return $resolver;
    }

    public function __construct()
    {
        $routeCollection = new RouteCollection();
        $routeCollection->add(
            'hello-world',
            new R('GET', '/', function () {
                return new Response('Hello world!');
            })
        );

        parent::__construct($routeCollection, $this->getActionResolver());
    }
}
