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
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

final class Emitter implements EmitterInterface
{
    /**
     * @var \Zend\HttpHandlerRunner\Emitter\EmitterInterface
     */
    private $emitter;

    /**
     * Emitter constructor.
     *
     * @param \Zend\HttpHandlerRunner\Emitter\EmitterInterface $emitter
     */
    private function __construct(EmitterInterface $emitter)
    {
        $this->emitter = $emitter;
    }

    /**
     * Acts as static factory.
     *
     * @return \Zend\HttpHandlerRunner\Emitter\EmitterInterface
     */
    public static function make(): EmitterInterface
    {
        return new self(new SapiEmitter());
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return bool
     */
    public function emit(ResponseInterface $response): bool
    {
        return $this->emitter->emit($response);
    }
}
