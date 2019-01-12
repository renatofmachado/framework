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

namespace Narration\Framework\Http\Message;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

final class Response
{
    /**
     * Creates a new JSON response.
     *
     * @param array|null $data
     * @param int $status
     * @param array $headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function json(array $data = null, int $status = 200, array $headers = []): ResponseInterface
    {
        return new JsonResponse($data, $status, $headers);
    }
}
