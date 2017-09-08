<?php

namespace Wearesho\Cpa\Interfaces;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Wearesho\Cpa\Exceptions\DuplicatedConversionException;
use Wearesho\Cpa\Exceptions\UnsupportedConversionTypeException;

/**
 * Interface PostbackServiceInterface
 * @package Wearesho\Cpa\Interfaces
 */
interface PostbackServiceInterface
{
    /**
     * PostbackServiceInterface constructor.
     *
     * @param ConversionRepositoryInterface $repository Will be used to check for double sending conversions
     * @param ClientInterface $client Will be used to send HTTP requests
     */
    public function __construct(ConversionRepositoryInterface $repository, ClientInterface $client);

    /**
     * Sending POST query to CPA network after creating conversion
     *
     * @param ConversionInterface $conversion
     *
     * @throws UnsupportedConversionTypeException
     * @throws DuplicatedConversionException
     * @throws RequestException
     *
     * @return ResponseInterface
     */
    public function send(ConversionInterface $conversion): ResponseInterface;
}