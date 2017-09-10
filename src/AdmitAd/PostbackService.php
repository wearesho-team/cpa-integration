<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/10/17
 * Time: 11:19 AM
 */

namespace Wearesho\Cpa\AdmitAd;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Wearesho\Cpa\Exceptions\DuplicatedConversionException;
use Wearesho\Cpa\Exceptions\UnsupportedConfigException;
use Wearesho\Cpa\Exceptions\UnsupportedConversionTypeException;
use Wearesho\Cpa\Interfaces\ConversionInterface;
use Wearesho\Cpa\Interfaces\ConversionRepositoryInterface;
use Wearesho\Cpa\Interfaces\PostbackServiceConfigInterface;
use Wearesho\Cpa\Interfaces\PostbackServiceInterface;

class PostbackService implements PostbackServiceInterface
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
    public function __construct(ConversionRepositoryInterface $repository, ClientInterface $client, PostbackServiceConfigInterface $config = null)
    {
        parent::__construct($repository, $client, $config);
    }

    /**
     * @param PostbackServiceConfigInterface $config
     * @throws UnsupportedConfigException
     * @return PostbackServiceInterface
     */
    public function setConfig(PostbackServiceConfigInterface $config): PostbackServiceInterface
    {
        // TODO: Implement setConfig() method.
    }

    /**
     * @return PostbackServiceConfigInterface|null
     */
    public function getConfig()
    {
        // TODO: Implement getConfig() method.
    }

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
    public function send(ConversionInterface $conversion): ResponseInterface
    {
        // TODO: Implement send() method.
    }
}