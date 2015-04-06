<?php

namespace CotaPreco\Action\Resolver;

use CotaPreco\Action\ActionResolverInterface;
use CotaPreco\Action\Exception\UnresolveableActionException;

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
     *
     * @throws UnresolveableActionException when none of available strategies
     * can resolve `$action`
     */
    public function resolve($action)
    {
        /* @var ResolveStrategyInterface[] $candidates */
        $candidates = array_filter(
            $this->strategies,
            function (ResolveStrategyInterface $resolver) use ($action) {
                return $resolver->canResolve($action);
            }
        );

        /* @var ResolveStrategyInterface|null $resolver */
        $resolver = current($candidates);

        if ($resolver) {
            return $resolver->resolve($action);
        }

        throw new UnresolveableActionException();
    }
}
