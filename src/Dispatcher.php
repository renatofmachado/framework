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
     * Dispatcher constructor.
     *
     * @param \Narration\Http\Route[] $routes
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
        $fastRouteDispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            foreach ($this->routes as $url => $route) {
                $r->{$route->getVerb()}($route->getUrl(), $route->getRequestHandlerClass());
            }
        });

        $dispatcher = new \Middlewares\Utils\Dispatcher([
            new \Middlewares\FastRoute($fastRouteDispatcher),
            new \Middlewares\RequestHandler(),
        ]);

        return $dispatcher->dispatch($request);
    }
}
