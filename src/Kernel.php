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
    private $dispatcher;

    private function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public static function fromPath(string $path): self
    {
        $routes = (new RoutesFinder())->find($path);

        return new self(new Dispatcher($routes));
    }

    public function handle($request)
    {
        $response = $this->dispatcher->dispatch($request);

        return $response;
    }

    public function terminate(): void
    {
        // ..
    }
}
