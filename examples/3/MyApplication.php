<?php

use CotaPreco\Action\ResolveableActionRoute as R;
use CotaPreco\Action\Resolver\ResolverChain;
use CotaPreco\Action\Resolver\ResolveStrategyActionResolverAdapter;
use CotaPreco\Action\Resolver\ZendServiceManagerActionResolver;
use CotaPreco\Application;
use Symfony\Component\Routing\RouteCollection;
use Zend\ServiceManager\Config as ServiceManagerConfig;
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
        $serviceManager = new ServiceManager(new ServiceManagerConfig(
            require_once __DIR__ . '/User/User.module.php'
        ));

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
        $routes->add('getAllUsers', new R('GET', '/users', GetUserList::class));

        parent::__construct($routes, $this->getActionResolver());
    }
}
