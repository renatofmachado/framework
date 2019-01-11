<?php

declare(strict_types=1);

/**
 * This file is part of NunoMaduro SkeletonPhp.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Narration\Http;

use Narration\Http\Middleware\AfterHandlerStack;
use Narration\Http\Middleware\BeforeHandlerStack;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @internal
 */
final class Dispatcher
{
    /**
     * @var array
     */
    private $routes;

    /**
     * Dispatcher constructor.
     *
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        // Create the routing dispatcher
        $fastRouteDispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            foreach ($this->routes as $url => $route) {
                $r->{$route[0]}($url, $route[1]);
            }
        });

//        $middlewareStack = new MiddlewareStack();


        $dispatcher = new \Middlewares\Utils\Dispatcher([
            new \Middlewares\FastRoute($fastRouteDispatcher),
            //Handle the route
            new BeforeHandlerStack(),
            new \Middlewares\RequestHandler(),
        ]);


        $response = $dispatcher->dispatch($request);

        return $response;
    }
}
