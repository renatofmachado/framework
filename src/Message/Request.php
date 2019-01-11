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
use Zend\Diactoros\ServerRequestFactory;

final class Request
{
    /**
     * Captures the request from the current server.
     *
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    public static function capture(): ServerRequestInterface
    {
        return ServerRequestFactory::fromGlobals();
    }
}
