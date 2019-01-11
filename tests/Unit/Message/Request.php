<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testContract(): void
    {
        $this->assertInstanceOf(ServerRequestInterface::class, new Request());
    }
}
