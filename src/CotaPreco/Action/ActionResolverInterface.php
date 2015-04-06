<?php

namespace CotaPreco\Action;

use CotaPreco\Action\Exception\ActionNotFoundException;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
interface ActionResolverInterface
{
    /**
     * @throws ActionNotFoundException quando não for possível resolver `$action`
     * @param  string $action
     * @return ExecutableHttpActionInterface
     */
    public function resolve($action);
}
