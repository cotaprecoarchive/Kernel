<?php

namespace CotaPreco\Action;

use CotaPreco\Action\Exception\ActionNotFoundException;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
interface ActionResolverInterface
{
    /**
     * @throws ActionNotFoundException when `$action` cannot be resolved
     * by any resolver
     *
     * @param  string $action
     * @return ExecutableHttpActionInterface
     */
    public function resolve($action);
}
