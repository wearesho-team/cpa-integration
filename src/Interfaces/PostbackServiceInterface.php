<?php

namespace Wearesho\Cpa\Interfaces;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Wearesho\Cpa\Exceptions\DuplicatedConversionException;
use Wearesho\Cpa\Exceptions\UnsupportedConfigException;
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
     * @param PostbackServiceConfigInterface $config
     *
     * @throws UnsupportedConfigException
     */
    public function __construct(
        ConversionRepositoryInterface $repository,
        ClientInterface $client,
        PostbackServiceConfigInterface $config = null
    );

    /**
     * @param PostbackServiceConfigInterface $config
     * @throws UnsupportedConfigException
     * @return PostbackServiceInterface
     */
    public function setConfig(PostbackServiceConfigInterface $config): PostbackServiceInterface;

    /**
     * @return PostbackServiceConfigInterface|null
     */
    public function getConfig();

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