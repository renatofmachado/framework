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

use ReflectionClass;
use Symfony\Component\Finder\Finder;

/**
 * @internal
 */
final class RoutesFinder
{
    /**
     * Holds the php declared classes.
     *
     * @var string[]|null
     */
    private static $declaredClasses;

    /**
     * @param string $path
     *
     * @return \Narration\Http\Route[]
     *
     * @todo Remove symfony dependency.
     */
    public function find(string $path): array
    {
        $path = realpath($path);

        $requestHandlersClass = array_filter($this->getProjectClasses($path), function (string $class) use ($path) {
            $fileName = (new ReflectionClass($class))->getFileName() ?: '';

            return strpos($fileName, $path) === 0;
        });

        return array_map(function ($requestHandlerClass) use ($path) {
            $reflector = new ReflectionClass($requestHandlerClass);
            $fileName = $reflector->getFileName();
            $relative = str_replace($path, '', $fileName);
            $parts = explode('/', $relative);

            $verb = end($parts);
            $url = strtolower(str_replace($verb, '', $relative));
            $verb = str_replace(['/', '.php'], '', strtolower($verb));

            if (empty($url)) {
                $url = '/';
            }

            $routes[$url] = [$verb, $requestHandlerClass];

            return new Route($requestHandlerClass, $url, $verb);
        }, $requestHandlersClass);
    }

    /**
     * @return string[]
     */
    private function getProjectClasses(string $in): array
    {
        if (self::$declaredClasses === null) {
            $configFiles = Finder::create()->files()->name('*.php')->in($in);
            foreach ($configFiles->files() as $file) {
                require_once $file;
            }
            self::$declaredClasses = get_declared_classes();
        }

        return self::$declaredClasses;
    }
}
