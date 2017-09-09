<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/8/17
 * Time: 4:52 PM
 */

namespace Wearesho\Cpa\Postback;


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

use Wearesho\Cpa\PrimeLead\PostbackService as PrimeLeadPostbackService;

use Wearesho\Cpa\SalesDoubler\PostbackService as SalesDoublerPostbackService;


/**
 * Class PostbackServiceFactory
 * @package Wearesho\Cpa
 */
class PostbackService implements PostbackServiceInterface
{
    /** @var PostbackServiceConfig | null */
    protected $config;

    /** @var ClientInterface */
    protected $client;

    /** @var ConversionRepositoryInterface */
    protected $repository;

    /** @var PostbackServiceInterface[] */
    protected $services;

    /**
     * PostbackServiceFactory constructor.
     *
     * @param ConversionRepositoryInterface $repository
     * @param ClientInterface $client
     * @param PostbackServiceConfig|PostbackServiceConfigInterface $config
     * @param PostbackServiceInterface[] $services
     *
     * @throws UnsupportedConfigException
     */
    public function __construct(
        ConversionRepositoryInterface $repository,
        ClientInterface $client,
        PostbackServiceConfigInterface $config = null,
        array $services = null
    )
    {
        $this->repository = $repository;
        $this->client = $client;
        $config && $this->setConfig($config);

        if (is_null($services)) {
            $services = [
                new SalesDoublerPostbackService($repository, $client),
                new PrimeLeadPostbackService($repository, $client),
            ];
        }
        $this->services = $services;
    }


    /**
     * @param PostbackServiceConfigInterface $config
     * @throws UnsupportedConfigException
     * @return PostbackServiceInterface
     */
    public function setConfig(PostbackServiceConfigInterface $config): PostbackServiceInterface
    {
        if (!$config instanceof PostbackServiceConfig) {
            throw new UnsupportedConfigException($this, $config);
        }

        $this->config = $config;
        return $this;
    }

    /**
     * @return PostbackServiceConfigInterface|null
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Try each service to send conversion, while getting UnsupportedConversionException
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
        foreach ($this->services as $service) {
            if (is_null($service->getConfig())) {
                $config = $this->config->getConfiguredConfigInstance($service);
                if ($config instanceof PostbackServiceConfigInterface) {
                    $this->setConfig($config);
                }
            }

            try {
                $service->send($conversion);
            } catch (UnsupportedConversionTypeException $exception) {
            }
        }
        throw new UnsupportedConversionTypeException($this, $conversion);
    }
}