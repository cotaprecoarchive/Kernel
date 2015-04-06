<?php

namespace CotaPreco\Action\Resolver;

use CotaPreco\Action\ActionResolverInterface;
use CotaPreco\Action\Exception\ActionNotFoundException;
use CotaPreco\Action\Exception\NotExecutableException;
use CotaPreco\Action\ExecutableHttpActionInterface;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class ResolveStrategyActionResolverAdapter implements ResolveStrategyInterface
{
    /**
     * @var ActionResolverInterface
     */
    private $resolver;

    /**
     * @var ExecutableHttpActionInterface[]
     */
    private $alreadyResolvedActions = [];

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

        if (isset($this->alreadyResolvedActions[$action])) {
            return true;
        }

        try {
            $this->alreadyResolvedActions[$action] = $this->resolver->resolve(
                $action
            );
        } catch (\Exception $e) {
            $isNotExecutable = $e instanceof NotExecutableException;
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
        if (isset($this->alreadyResolvedActions[$action])) {
            return $this->alreadyResolvedActions[$action];
        }

        return $this->resolver->resolve($action);
    }
}
