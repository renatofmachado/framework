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

namespace Narration\Framework\Container;

use Narration\Framework\ClassFinder;

/**
 * @internal
 */
final class InjectorFinder
{
    /**
     * @var \Narration\Framework\ClassFinder
     */
    private $classFinder;

    /**
     * RouteFinder constructor.
     *
     * @param \Narration\Framework\ClassFinder $classFinder
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
     * @return string[]
     */
    public function find(string $path): array
    {
        $path = (string) realpath($path);

        return $this->classFinder->find($path);
    }
}
