<?php
declare(strict_types=1);

namespace Narration\Http;


use Narration\Http\Contracts\AfterRequestHandlingInterface;
use Narration\Http\Contracts\BeforeRequestHandlingInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareStack
{
    protected $before = [];

    protected $after = [];

    protected $handler;

    public function __construct(RequestHandlerInterface $requestHandler)
    {
        $this->handler = $requestHandler;
    }

    public function ordered() : array
    {
        return array_merge(
            $this->before,
            $this->getRequestHandlerMiddleware(),
            $this->after
        );
    }

    protected function getRequestHandlerMiddleware() : array
    {
        $middleware = [];
        if (property_exists($this->handler, 'middleware')) {
            $middleware = $this->instantiate($this->handler->middleware);
        }

        return $this->sort($middleware);
    }

    protected function sort(array $middlewares) : array
    {
        $before = [];
        $after = [];

        foreach ($middlewares as $middleware) {
            if ($middleware instanceof BeforeRequestHandlingInterface) {
                $before[] = $middleware;
            } elseif ($middleware instanceof AfterRequestHandlingInterface) {
                $after[] = $middleware;
            }
        }

        return array_merge($before, $after);
    }

    protected function instantiate(array $items) : array
    {
        return array_map(function ($middlewareClass) {
            return new $middlewareClass(); // TODO: Dependency Injection when possible.
        }, $items);
    }

    /**
     * @param array $before
     * @return MiddlewareStack
     */
    public function addBefore(array $before) : self
    {
        $this->before = array_merge($this->before, $before);

        return $this;
    }

    /**
     * @param array $after
     * @return MiddlewareStack
     */
    public function addAfter(array $after) : self
    {
        $this->after = array_merge($this->after, $after);

        return $this;
    }
}