<?php

namespace CotaPreco\Action\Resolver;

use CotaPreco\Action\ActionResolverInterface;
use CotaPreco\Action\Exception\ActionNotExecutableException;
use CotaPreco\Action\Exception\ActionNotFoundException;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class ResolveStrategyActionResolverAdapter implements
    ResolveStrategyInterface
{
    /**
     * @var ActionResolverInterface
     */
    private $resolver;

    /**
     * @param ActionResolverInterface $resolver
     */
    public function __construct(ActionResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * {@inheritDoc}
     */
    public function canResolve($action)
    {
        if (! is_string($action)) {
            return false;
        }

        try {
            $this->resolver->resolve($action);
        } catch (\Exception $e) {
            $isNotExecutable = $e instanceof ActionNotExecutableException;
            $isNotFound      = $e instanceof ActionNotFoundException;

            if ($isNotExecutable || $isNotFound) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function resolve($action)
    {
        return $this->resolver->resolve($action);
    }
}
