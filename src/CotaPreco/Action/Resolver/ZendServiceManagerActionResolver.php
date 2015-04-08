<?php

namespace CotaPreco\Action\Resolver;

use CotaPreco\Action\ActionResolverInterface;
use CotaPreco\Action\Exception\ActionNotExecutableException;
use CotaPreco\Action\Exception\ActionNotFoundException;
use CotaPreco\Action\ExecutableHttpActionInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class ZendServiceManagerActionResolver implements ActionResolverInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * {@inheritDoc}
     */
    public function resolve($action)
    {
        if (! $this->serviceLocator->has($action)) {
            throw new ActionNotFoundException();
        }

        /* @var ExecutableHttpActionInterface $action */
        $action = $this->serviceLocator->get($action);

        if (! $action instanceof ExecutableHttpActionInterface) {
            throw new ActionNotExecutableException();
        }

        return $action;
    }
}
