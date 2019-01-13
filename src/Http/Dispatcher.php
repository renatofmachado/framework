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

namespace Narration\Framework\Http;

use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narration\Framework\Container\ContainerFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @internal
 */
final class Dispatcher
{
    /**
     * @var \Narration\Framework\Container\ContainerFactory
     */
    private $containerFactory;

    /**
     * @var \Narration\Framework\Http\Route[]
     */
    private $routes;

    /**
     * @var string[]
     */
    private $middleware;

    /**
     * Dispatcher constructor.
     *
     * @param  \Narration\Framework\Container\ContainerFactory $containerFactory
     * @param  mixed[] $routes
     * @param  mixed[] $middleware
     */
    public function __construct(ContainerFactory $containerFactory, array $routes, array $middleware)
    {
        $this->containerFactory = $containerFactory;
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
        $definitions = [];

        foreach ($this->routes as $url => $route) {
            $definitions[$route->getRequestHandlerClass()] = $route->getRequestHandlerClass();
        }
        $container = $this->containerFactory->createContainer($definitions);

        $fastRouteDispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $r) use ($container) {
            foreach ($this->routes as $url => $route) {
                $requestHandler = $container->get($route->getRequestHandlerClass());

                $r->{$route->getVerb()}($route->getUrl(), $requestHandler);
            }
        });

        $middleware = [new FastRoute($fastRouteDispatcher)];

        $middleware = array_merge($middleware, array_map(function ($middlewareClass) {
            return new $middlewareClass();
        }, $this->middleware));

        $middleware[] = new RequestHandler($container);

        $dispatcher = new \Middlewares\Utils\Dispatcher($middleware);

        return $dispatcher->dispatch($request);
    }
}
