<?php

namespace CotaPreco\Action\Resolver;

use CotaPreco\Action\ExecutableHttpActionInterface;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
interface ResolveStrategyInterface
{
    /**
     * @param  string $action
     * @return bool
     */
    public function canResolve($action);

    /**
     * @param  string $action
     * @return ExecutableHttpActionInterface
     */
    public function resolve($action);
}
