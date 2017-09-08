<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/8/17
 * Time: 4:52 PM
 */

namespace Wearesho\Cpa;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

use Symfony\Component\Config\Definition\Processor;
use Wearesho\Cpa\Exceptions\DuplicatedConversionException;
use Wearesho\Cpa\Exceptions\UnsupportedConversionTypeException;

use Wearesho\Cpa\Interfaces\ConversionInterface;
use Wearesho\Cpa\Interfaces\ConversionRepositoryInterface;
use Wearesho\Cpa\Interfaces\PostbackServiceInterface;

use Wearesho\Cpa\PrimeLead\PostbackService as PrimeLeadPostbackService;
use Wearesho\Cpa\PrimeLead\PostbackServiceConfig as PrimeLeadPostbackServiceConfig;

use Wearesho\Cpa\SalesDoubler\PostbackService as SalesDoublerPostbackService;
use Wearesho\Cpa\SalesDoubler\PostbackServiceConfig as SalesDoublerPostbackServiceConfig;


/**
 * Class PostbackServiceFactory
 * @package Wearesho\Cpa
 */
class PostbackService implements PostbackServiceInterface
{
    /** @var string[], key as service class, value as service config class */
    protected static $services = [
        PrimeLeadPostbackService::class => PrimeLeadPostbackServiceConfig::class,
        SalesDoublerPostbackService::class => SalesDoublerPostbackServiceConfig::class,
    ];

    /** @var array with postback services configurations */
    protected $config;

    /** @var ClientInterface */
    protected $client;

    /** @var ConversionRepositoryInterface */
    protected $repository;

    /**
     * PostbackServiceFactory constructor.
     *
     * @param ConversionRepositoryInterface $repository
     * @param ClientInterface $client
     * @param array $config
     */
    public function __construct(ConversionRepositoryInterface $repository, ClientInterface $client, array $config = [])
    {
        $this->repository = $repository;
        $this->client = $client;
        $this->config = [];
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
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
        $processor = new Processor();
    }
}