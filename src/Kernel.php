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

use Narration\Http\Middleware\MiddlewareBeforeDispatcher;

final class Kernel
{
    public static function fromPath(string $path)
    {
        return new self();
    }

    public function handle($request)
    {
        // Create the routing dispatcher
        $fastRouteDispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            $r->get('/', \Application\Http\RequestHandlers\Get::class);
        });

        $middlewareStack = (new MiddlewareStack(
            new \Application\Http\RequestHandlers\Get()
        ))->addBefore([
            new \Middlewares\FastRoute($fastRouteDispatcher),
            //Handle the route
            new \Middlewares\RequestHandler(),
        ]);

        $dispatcher = new \Middlewares\Utils\Dispatcher($middlewareStack->ordered());

        $response = $dispatcher->dispatch($request);

        return $response;
    }

    public function terminate()
    {

    }
}
