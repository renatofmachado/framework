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

namespace Narration\Http;

/**
 * @internal
 */
final class Route
{
    private $requestHandlerClass;

    private $url;

    private $verb;

    /**
     * @param string $requestHandlerClass
     * @param string $url
     * @param string $verb
     */
    public function __construct(string $requestHandlerClass, string $url, string $verb)
    {
        $this->requestHandlerClass = $requestHandlerClass;
        $this->url = $url;
        $this->verb = $verb;
    }

    /**
     * @return string
     */
    public function getRequestHandlerClass(): string
    {
        return $this->requestHandlerClass;
    }

    /**
     * @param string $requestHandlerClass
     */
    public function setRequestHandlerClass(string $requestHandlerClass): void
    {
        $this->requestHandlerClass = $requestHandlerClass;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * @param string $verb
     */
    public function setVerb($verb): void
    {
        $this->verb = $verb;
    }
}
