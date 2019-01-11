<?php

declare(strict_types=1);

/**
 * This file is part of Narration Framework.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Narration\Http;

use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @internal
 */
final class Dispatcher
{
    /**
     * @var \Narration\Http\Route[]
     */
    private $routes;

    /**
     * @var string[]
     */
    private $middleware;

    /**
     * @param \Narration\Http\Route[] $routes
     * @param string[] $middleware
     */
    public function __construct(array $routes, array $middleware)
    {
        $this->routes = $routes;
        $this->middleware = $middleware;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        $fastRouteDispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            foreach ($this->routes as $url => $route) {
                $r->{$route->getVerb()}($route->getUrl(), $route->getRequestHandlerClass());
            }
        });

        $middleware = [new FastRoute($fastRouteDispatcher)];

        $middleware = array_merge($middleware, array_map(function ($middlewareClass) {
            return new $middlewareClass;
        }, $this->middleware));

        $middleware[] = new RequestHandler();

        $dispatcher = new \Middlewares\Utils\Dispatcher($middleware);

        return $dispatcher->dispatch($request);
    }
}
