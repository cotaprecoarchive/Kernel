<?php

namespace CotaPreco\Action;

use CotaPreco\Action\Callback\CallableHttpActionWrapper;
use Symfony\Component\Routing\Route;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class CallbackActionRoute extends Route
{
    /**
     * @param string   $method
     * @param array    $path
     * @param callable $callback
     */
    public function __construct($method, $path, callable $callback)
    {
        parent::__construct(
            $path,
            [
                'action' => new CallableHttpActionWrapper($callback)
            ],
            [],
            [],
            null,
            [],
            $method,
            null
        );
    }
}
