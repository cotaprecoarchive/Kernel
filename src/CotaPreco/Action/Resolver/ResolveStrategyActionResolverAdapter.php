<?php

/*
 * Copyright (c) 2015 Cota Preço
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

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
