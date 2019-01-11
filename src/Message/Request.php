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

namespace Narration\Http\Message;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Zend\Diactoros\ServerRequestFactory;

final class Request implements ServerRequestInterface
{
    private $baseRequest;

    private function __construct(ServerRequestInterface $baseRequest)
    {
        $this->baseRequest = $baseRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function getProtocolVersion(): string
    {
        return $this->baseRequest->getProtocolVersion();
    }

    /**
     * {@inheritdoc}
     */
    public function withProtocolVersion($version): ServerRequestInterface
    {
        $this->baseRequest->withProtocolVersion($version);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders(): array
    {
        return $this->baseRequest->getHeaders();
    }

    /**
     * {@inheritdoc}
     */
    public function hasHeader($name): bool
    {
        return $this->baseRequest->hasHeader($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($name): array
    {
        return $this->baseRequest->getHeader($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderLine($name): string
    {
        return $this->baseRequest->getHeaderLine($name);
    }

    /**
     * {@inheritdoc}
     */
    public function withHeader($name, $value): ServerRequestInterface
    {
        $this->baseRequest->withHeader($name, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedHeader($name, $value)
    {
        $this->baseRequest->withAddedHeader($name, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutHeader($name)
    {
        $this->baseRequest->withoutHeader($name);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody(): StreamInterface
    {
        return $this->baseRequest->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function withBody(StreamInterface $body): ServerRequestInterface
    {
        return $this->baseRequest->withBody($body);
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestTarget(): string
    {
        return $this->baseRequest->getRequestTarget();
    }

    /**
     * {@inheritdoc}
     */
    public function withRequestTarget($requestTarget): ServerRequestInterface
    {
        return $this->baseRequest->withRequestTarget($requestTarget);
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return $this->baseRequest->getMethod();
    }

    /**
     * {@inheritdoc}
     */
    public function withMethod($method): ServerRequestInterface
    {
        return $this->baseRequest->withMethod($method);
    }

    /**
     * {@inheritdoc}
     */
    public function getUri(): UriInterface
    {
        return $this->baseRequest->getUri();
    }

    /**
     * {@inheritdoc}
     */
    public function withUri(UriInterface $uri, $preserveHost = false): ServerRequestInterface
    {
        return $this->baseRequest->withUri($uri, $preserveHost);
    }

    /**
     * {@inheritdoc}
     */
    public function getServerParams(): array
    {
        return $this->baseRequest->getServerParams();
    }

    /**
     * {@inheritdoc}
     */
    public function getCookieParams(): array
    {
        return $this->baseRequest->getCookieParams();
    }

    /**
     * {@inheritdoc}
     */
    public function withCookieParams(array $cookies): ServerRequestInterface
    {
        $this->baseRequest->withCookieParams($cookies);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParams(): array
    {
        return $this->baseRequest->getQueryParams();
    }

    /**
     * {@inheritdoc}
     */
    public function withQueryParams(array $query): ServerRequestInterface
    {
        $this->baseRequest->withQueryParams($query);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadedFiles(): array
    {
        return $this->baseRequest->getUploadedFiles();
    }

    /**
     * {@inheritdoc}
     */
    public function withUploadedFiles(array $uploadedFiles): ServerRequestInterface
    {
        $this->baseRequest->withUploadedFiles($uploadedFiles);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParsedBody()
    {
        return $this->baseRequest->getParsedBody();
    }

    /**
     * {@inheritdoc}
     */
    public function withParsedBody($data): ServerRequestInterface
    {
        $this->baseRequest->withParsedBody($data);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes(): array
    {
        return $this->baseRequest->getAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute($name, $default = null)
    {
        return $this->baseRequest->getAttribute($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function withAttribute($name, $value): ServerRequestInterface
    {
        $this->baseRequest->withAttribute($name, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutAttribute($name): ServerRequestInterface
    {
        $this->baseRequest->withoutAttribute($name);

        return $this;
    }

    public static function capture(): ServerRequestInterface
    {
        return new self(ServerRequestFactory::fromGlobals());
    }
}
