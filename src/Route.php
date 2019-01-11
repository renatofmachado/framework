<?php

declare(strict_types=1);

namespace Narration\Http;

/**
 * @internal
 */
final class Route
{
    private $requestHandlerClass;

    private $url;

    private $verb;

    public function __construct(string $requestHandlerClass, string $url, string $verb)
    {
        $this->requestHandlerClass = $requestHandlerClass;
        $this->url = $url;
        $this->verb = $verb;
    }

    public function getRequestHandlerClass(): string
    {
        return $this->requestHandlerClass;
    }

    public function setRequestHandlerClass(string $requestHandlerClass): void
    {
        $this->requestHandlerClass = $requestHandlerClass;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getVerb(): string
    {
        return $this->verb;
    }

    public function setVerb($verb): void
    {
        $this->verb = $verb;
    }
}
