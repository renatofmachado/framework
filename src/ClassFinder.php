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

namespace Narration\Framework;

use ReflectionClass;
use Symfony\Component\Finder\Finder;

/**
 * @internal
 */
final class ClassFinder
{
    /**
     * The php declared classes.
     *
     * @var array
     */
    private static $declaredClasses = [];

    /**
     * Find classes on the given path from the given type.
     *
     * @param string $path
     * @param string|null $type
     *
     * @return string[]
     */
    public function find(string $path, string $type = null): array
    {
        $path = (string) realpath($path);

        return array_filter($this->requireClasses($path), function (string $class) use ($path, $type) {
            $reflection = new ReflectionClass($class);

            $fileName = $reflection->getFileName() ?: '';

            return strpos($fileName, $path) === 0 && ($type === null || $reflection->implementsInterface($type));
        });
    }

    /**
     * @param string $in
     *
     * @return string[]
     */
    private function requireClasses(string $in): array
    {
        if (! array_key_exists($in, self::$declaredClasses)) {
            $configFiles = Finder::create()->files()->name('*.php')->in($in);
            foreach ($configFiles->files() as $file) {
                require_once $file;
            }

            self::$declaredClasses[$in] = get_declared_classes();
        }

        return self::$declaredClasses[$in];
    }
}
