<?php

declare(strict_types=1);

namespace Narration\Http;

/**
 * @internal
 */
final class Route
{
    /**
     * The request handler class name.
     *
     * @var string
     */
    private $requestHandlerClass;

    /**
     * The url.
     *
     * @var string
     */
    private $url;

    /**
     * The http verb.
     *
     * @var string
     */
    private $verb;

    /**
     * Route constructor.
     *
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
     * Returns the request handler class.
     *
     * @return string
     */
    public function getRequestHandlerClass(): string
    {
        return $this->requestHandlerClass;
    }

    /**
     * Returns the url.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Returns the verb.
     *
     * @return string
     */
    public function getVerb(): string
    {
        return $this->verb;
    }
}
