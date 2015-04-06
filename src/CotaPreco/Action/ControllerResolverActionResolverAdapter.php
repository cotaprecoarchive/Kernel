<?php

namespace CotaPreco\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class ControllerResolverActionResolverAdapter implements
    ControllerResolverInterface
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
    public function getController(Request $request)
    {
        if ($request->attributes->has('action')) {
            /* @var ExecutableHttpActionInterface $action */
            $action = $this->resolver->resolve($request->attributes->get('action'));

            return function(Request $request) use ($action) {
                return $action->execute($request);
            };
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getArguments(Request $request, $controller)
    {
        return [
            $request
        ];
    }
}
