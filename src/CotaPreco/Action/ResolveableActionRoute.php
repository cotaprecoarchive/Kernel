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

namespace CotaPreco\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 *
 * @method static ResolveableActionRoute HEAD(string $path, $action)
 * @method static ResolveableActionRoute GET(string $path, $action)
 * @method static ResolveableActionRoute POST(string $path, $action)
 * @method static ResolveableActionRoute PUT(string $path, $action)
 * @method static ResolveableActionRoute PATCH(string $path, $action)
 * @method static ResolveableActionRoute DELETE(string $path, $action)
 * @method static ResolveableActionRoute PURGE(string $path, $action)
 * @method static ResolveableActionRoute OPTIONS(string $path, $action)
 * @method static ResolveableActionRoute TRACE(string $path, $action)
 * @method static ResolveableActionRoute CONNECT(string $path, $action)
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

    /**
     * @param  string $method
     * @param  array  $arguments
     * @return self
     */
    public static function __callStatic($method, array $arguments)
    {
        $method = strtoupper($method);

        /* @var string[] $allowedHttpMethods */
        $allowedHttpMethods = [
            Request::METHOD_HEAD,
            Request::METHOD_GET,
            Request::METHOD_POST,
            Request::METHOD_PUT,
            Request::METHOD_PATCH,
            Request::METHOD_DELETE,
            Request::METHOD_PURGE,
            Request::METHOD_OPTIONS,
            Request::METHOD_TRACE,
            Request::METHOD_CONNECT
        ];

        if (! in_array($method, $allowedHttpMethods, true)) {
            // TODO: MethodNotAllowedException?
        }

        if (! isset($arguments[0], $arguments[1])) {
            // TODO: InvalidArgumentException?
        }

        /* @var string $path */
        $path   = (string) $arguments[0];

        /* @var string|callable $action */
        $action = $arguments[1];

        return new self($method, $path, $action);
    }
}
