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

use Psr\Http\Server\RequestHandlerInterface;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

/**
 * @internal
 */
final class RouteFinder
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
     * Find routes on the given path.
     *
     * @param string $path
     *
     * @return \Narration\Http\Route[]
     */
    public function find(string $path): array
    {
        $path = (string) realpath($path);

        return array_map(function ($requestHandlerClass) use ($path) {
            $fileName = (string) (new ReflectionClass($requestHandlerClass))->getFileName();

            $relative = str_replace($path, '', $fileName);
            $parts = explode('/', $relative);

            $verb = (string) end($parts);
            $url = strtolower(str_replace($verb, '', $relative));
            $verb = str_replace(['/', '.php'], '', strtolower($verb));

            if (empty($url)) {
                $url = '/';
            }

            $routes[$url] = [$verb, $requestHandlerClass];

            return new Route($requestHandlerClass, $url, $verb);
        }, $this->classFinder->find($path, RequestHandlerInterface::class));
    }
}
