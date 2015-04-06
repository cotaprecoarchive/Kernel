<?php

namespace CotaPreco\Action\Callback;

use CotaPreco\Action\ExecutableHttpActionInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class CallableHttpActionWrapper implements ExecutableHttpActionInterface
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
        return $this->callable($request);
    }
}
