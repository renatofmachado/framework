<?php
declare(strict_types=1);

namespace Narration\Http;


use Narration\Http\Contracts\AfterRequestHandlingInterface;
use Narration\Http\Contracts\BeforeRequestHandlingInterface;
use Narration\Http\Contracts\Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class MiddlewareStack implements MiddlewareInterface
{
    protected $stack = [];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (class_exists($className = $request->getAttribute('request-handler'))) {
            $request = $this->handleMiddlewareForRequestHandler($className, $request);
        }

        return $handler->handle($request);
    }

    protected function handleMiddlewareForRequestHandler(string $classname, ServerRequestInterface $request)
    {
        $this->setMiddlewareToResolve($classname);

        return $this->run($request);
    }

    protected function run(ServerRequestInterface $request)
    {
        foreach ($this->stack as $middleware) {
            if ($middleware instanceof Middleware) {
                $middleware->handle($request, function (ServerRequestInterface $new) use (&$request) {

                    foreach ($new->getAttributes() as $key => $value) {
                        $request = $request->withAttribute($key, $value);
                    }

                    return $request;
                });
            } 
        }

        return $request;
    }

    protected function setMiddlewareToResolve(string $requestHandler)
    {
        $this->handler = $this->newInstance($requestHandler);
        $this->stack = $this->getRequestHandlerMiddleware();
    }

    protected function getRequestHandlerMiddleware() : array
    {
        $middleware = [];
        if (property_exists($this->handler, 'middleware')) {
            $middleware = $this->instantiate($this->handler->middleware);
        }

        return $this->sort(
            $this->filter($middleware)
        );
    }

    abstract function filter(array $middlewares) : array;

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
            return $this->newInstance($middlewareClass);
        }, $items);
    }

    protected function newInstance($class)
    {
        return new $class();
    }
}