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

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

/**
 * @internal
 */
final class MiddlewareFinder
{
    /**
     * @var \Narration\Http\ClassFinder
     */
    private $classFinder;

    /**
     * RouteFinder constructor.
     *
     * @param \Narration\Http\ClassFinder $classFinder
     */
    public function __construct(ClassFinder $classFinder = null)
    {
        $this->classFinder = $classFinder ?? new ClassFinder();
    }

    /**
     * Find middlewares on the given path.
     *
     * @param string $path
     *
     * @return string[]
     */
    public function find(string $path): array
    {
        return $this->classFinder->find($path, MiddlewareInterface::class);
    }
}
