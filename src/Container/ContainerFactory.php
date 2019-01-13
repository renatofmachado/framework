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

use League\Container\Container;
use Psr\Container\ContainerInterface;

/**
 * @internal
 */
final class ContainerFactory
{
    /**
     * @var array
     */
    private $injectors;

    /**
     * ContainerFactory constructor.
     *
     * @param  array $injectors
     */
    public function __construct(array $injectors)
    {
        $this->injectors = $injectors;
    }

    /**
     * @param  array $definitions
     *
     * @return \Psr\Container\ContainerInterface
     */
    public function createContainer(array $definitions): ContainerInterface
    {
        $container = new Container();

        foreach ($this->injectors as $injector) {
            $definitions = (new $injector)($definitions);
        }

        foreach ($definitions as $abstract => $concrete) {
            if (is_string($concrete)) {
                $reflector = new \ReflectionMethod($concrete, '__construct');
                $arguments = array_map(function ($param) use ($container) {
                    return $param->getClass()->getName();
                }, $reflector->getParameters());

                $container->add($abstract, $concrete)->addArguments($arguments);
            } else {
                $container->add($abstract, $concrete);
            }
        }

        return $container;
    }
}
