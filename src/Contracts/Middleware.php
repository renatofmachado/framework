<?php

namespace Narration\Http\Contracts;


use Psr\Http\Message\ServerRequestInterface;

interface Middleware
{
    public function handle(ServerRequestInterface $request, callable $next) : ServerRequestInterface;
}