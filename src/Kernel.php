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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Kernel
{
    /**
     * The dispatcher instance.
     *
     * @var \Narration\Http\Dispatcher
     */
    private $dispatcher;

    /**
     * Kernel constructor.
     *
     * @param \Narration\Http\Dispatcher $dispatcher
     */
    private function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Creates a Kernel instances from the given path.
     *
     * @param  string $path
     *
     * @return \Narration\Http\Kernel
     */
    public static function fromPath(string $path): self
    {
        $routes = (new RouteFinder())->find($path.'/RequestHandlers');

        $middleware = (new MiddlewareFinder())->find($path.'/Middleware');

        return new self(new Dispatcher($routes, $middleware));
    }

    /**
     * Handles the given request.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->dispatcher->dispatch($request);

        return $response;
    }
}
