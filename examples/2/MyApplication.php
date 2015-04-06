<?php

use CotaPreco\Action\ResolveableActionRoute as R;
use CotaPreco\Action\Resolver\ResolverChain;
use CotaPreco\Action\Resolver\ResolveStrategyActionResolverAdapter;
use CotaPreco\Action\Resolver\ZendServiceManagerActionResolver;
use CotaPreco\Application;
use Symfony\Component\Routing\RouteCollection;
use Zend\ServiceManager\ServiceManager;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class MyApplication extends Application
{
    /**
     * @return ServiceManager
     */
    private function getServiceManager()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setInvokableClass(MultiplyTwoNumbers::class, MultiplyTwoNumbers::class);

        return $serviceManager;
    }

    /**
     * @return ResolverChain
     */
    private function getActionResolver()
    {
        $resolver = new ResolverChain();

        $resolver->addResolveStrategy(new ResolveStrategyActionResolverAdapter(
            new ZendServiceManagerActionResolver($this->getServiceManager())
        ));

        return $resolver;
    }

    public function __construct()
    {
        $routes = new RouteCollection();
        $routes->add('/mul/{x}/{y}', new R(
            'GET',
            '/mul/{x}/{y}',
            MultiplyTwoNumbers::class
        ));

        parent::__construct($routes, $this->getActionResolver());
    }
}
