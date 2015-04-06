<?php

namespace CotaPreco\Action\Resolver;

use CotaPreco\Action\ActionResolverInterface;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class ResolverChain implements ActionResolverInterface
{
    /**
     * @var ResolveStrategyInterface[]
     */
    private $strategies;

    /**
     * @param ResolveStrategyInterface $strategy
     */
    public function addResolveStrategy(ResolveStrategyInterface $strategy)
    {
        $this->strategies[] = $strategy;
    }

    /**
     * {@inheritDoc}
     */
    public function resolve($action)
    {
        /* @var ResolveStrategyInterface[] $candidates */
        $candidates = array_filter(
            $this->strategies,
            function (ResolveStrategyInterface $strategy) use ($action) {
                return $strategy->canResolve($action);
            }
        );

        /* @var ResolveStrategyInterface|null $resolver */
        $resolver = current($candidates);

        if (! is_null($resolver)) {
            return $resolver->resolve($action);
        }

        // TODO: UnresolveableActionException?
    }
}
