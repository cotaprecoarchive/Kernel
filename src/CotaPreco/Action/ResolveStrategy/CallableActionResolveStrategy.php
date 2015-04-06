<?php

namespace CotaPreco\Action\ResolveStrategy;

use CotaPreco\Action\CallableExecutableHttpActionAdapter;
use CotaPreco\Action\Resolver\ResolveStrategyInterface;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class CallableActionResolveStrategy implements ResolveStrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function canResolve($action)
    {
        return is_callable($action);
    }

    /**
     * {@inheritDoc}
     */
    public function resolve($action)
    {
        return new CallableExecutableHttpActionAdapter($action);
    }
}
