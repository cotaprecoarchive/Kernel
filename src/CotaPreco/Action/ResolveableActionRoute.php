<?php

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
