<?php

namespace CotaPreco\Action;

use Symfony\Component\Routing\Route;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class ResolveableActionRoute extends Route
{
    /**
     * @param string          $method
     * @param array           $path
     * @param string|callable $action
     */
    public function __construct($method, $path, $action)
    {
        parent::__construct(
            $path,
            [
                'action' => $action
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
