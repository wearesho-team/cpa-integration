<?php

namespace Wearesho\Cpa\Interfaces;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Wearesho\Cpa\Exceptions\DuplicatedConversionException;
use Wearesho\Cpa\Exceptions\UnsupportedConversionType;

/**
 * Interface PostbackServiceInterface
 * @package Wearesho\Cpa\Interfaces
 */
interface PostbackServiceInterface
{
    /**
     * Sending POST query to CPA network after creating conversion
     *
     * @param ConversionInterface $conversion
     *
     * @throws UnsupportedConversionType
     * @throws DuplicatedConversionException
     * @throws RequestException
     *
     * @return ResponseInterface
     */
    public function send(ConversionInterface $conversion): ResponseInterface;
}