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

/**
 * @internal
 */
final class Composer
{
    /**
     * @var array
     */
    private $content;

    /**
     * Composer constructor.
     *
     * @param array $content
     */
    public function __construct(array $content)
    {
        $this->content = $content;
    }

    /**
     * @param  string $path
     *
     * @return \Narration\Framework\Composer
     */
    public static function fromPath(string $path): self
    {
        $path = (string) realpath($path);

        $content = json_decode((string) file_get_contents($path), true);

        return new self($content);
    }

    /**
     * @return string
     */
    public function getRequestHandlersPath(): string
    {
        return $this->content['extra']['narration']['request-handlers-path'];
    }

    /**
     * @return string
     */
    public function getMiddlewarePath(): string
    {
        return $this->content['extra']['narration']['middleware-path'];
    }

    /**
     * @return string
     */
    public function getInjectorsPath(): string
    {
        return $this->content['extra']['narration']['injectors-path'];
    }
}
