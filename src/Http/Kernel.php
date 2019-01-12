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

use Narration\Framework\Composer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Narration\Framework\Container\ContainerFactory;
use Narration\Framework\Container\InjectorFinder;

final class Kernel
{
    /**
     * The dispatcher instance.
     *
     * @var \Narration\Framework\Http\Dispatcher
     */
    private $dispatcher;

    /**
     * Kernel constructor.
     *
     * @param \Narration\Framework\Http\Dispatcher $dispatcher
     */
    private function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Creates a Kernel instances from the given path.
     *
     * @param  string $composerPath
     *
     * @return \Narration\Framework\Http\Kernel
     */
    public static function create(string $composerPath): self
    {
        $composer = Composer::fromPath($composerPath);

        $routes = (new RouteFinder())->find($composer->getRequestHandlersPath());

        $middleware = (new MiddlewareFinder())->find($composer->getMiddlewarePath());

        $injectors = (new InjectorFinder())->find($composer->getInjectorsPath());

        $containerFactory = new ContainerFactory($injectors);

        return new self(new Dispatcher($containerFactory, $routes, $middleware));
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
