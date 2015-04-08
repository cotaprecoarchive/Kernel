<?php

namespace CotaPreco\Action;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class CallableExecutableHttpActionAdapter implements
    ExecutableHttpActionInterface
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Request $request)
    {
        /* @var callable $callback */
        $callback = $this->callable;

        return $callback($request);
    }
}
