<?php

declare(strict_types=1);

namespace Narration\Http\Middleware;


use Narration\Http\Contracts\BeforeRequestHandlingInterface;
use Narration\Http\MiddlewareStack;

class BeforeHandlerStack extends MiddlewareStack
{
    function filter(array $middlewares): array
    {
        return array_filter($middlewares, function ($middleware) {
            return $middleware instanceof BeforeRequestHandlingInterface;
        });
    }
}