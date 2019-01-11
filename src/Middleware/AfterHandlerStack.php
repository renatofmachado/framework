<?php

declare(strict_types=1);

namespace Narration\Http\Middleware;


use Narration\Http\Contracts\AfterRequestHandlingInterface;
use Narration\Http\MiddlewareStack;

class AfterHandlerStack extends MiddlewareStack
{
    function filter(array $middlewares): array
    {
        return array_filter($middlewares, function ($middleware) {
            return $middleware instanceof AfterRequestHandlingInterface;
        });
    }
}