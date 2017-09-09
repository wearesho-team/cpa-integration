<?php

namespace Wearesho\Cpa\Postback;


use Symfony\Component\Config\Definition\Processor;
use Wearesho\Cpa\Exceptions\NotImplementedException;
use Wearesho\Cpa\Exceptions\UnsupportedPostbackServiceException;
use Wearesho\Cpa\Interfaces\PostbackServiceConfigInterface;
use Wearesho\Cpa\Interfaces\PostbackServiceInterface;


use Wearesho\Cpa\PrimeLead\PostbackService as PrimeLeadPostbackService;
use Wearesho\Cpa\PrimeLead\PostbackServiceConfig as PrimeLeadPostbackServiceConfig;

use Wearesho\Cpa\SalesDoubler\PostbackService as SalesDoublerPostbackService;
use Wearesho\Cpa\SalesDoubler\PostbackServiceConfig as SalesDoublerPostbackServiceConfig;

/**
 * Class PostbackServiceConfig
 * @package Wearesho\Cpa\Postback
 */
class PostbackServiceConfig implements PostbackServiceConfigInterface
{
    /** @var  array will be used to fill postback service config properties */
    protected $config;

    /**
     * PostbackServiceConfig constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
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
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param PostbackServiceInterface $service
     * @throws UnsupportedPostbackServiceException
     * @return PostbackServiceConfigInterface
     */
    public function getConfiguredConfigInstance(PostbackServiceInterface $service)
    {
        $configInstance = $this->getConfigInstance($service);
        $rootIndex = $configInstance->getConfigTreeBuilderRoot();
        if (
            !array_key_exists($rootIndex, $this->config)
            || !is_array($this->config[$rootIndex])
        ) {
            return null;
        }

        $processor = new Processor();
        $config = $processor->processConfiguration($configInstance, $this->config);

        $closure = function ($key, $value) {
            $this->{$key} = $value;
        };

        foreach ($config as $key => $value) {
            $closure->call($configInstance, $key, $value);
        }

        return $configInstance;
    }

    /**
     * @param PostbackServiceInterface $service
     * @return PostbackServiceConfigInterface
     * @throws UnsupportedPostbackServiceException
     */
    public function getConfigInstance(PostbackServiceInterface $service): PostbackServiceConfigInterface
    {
        switch (get_class($service)) {
            case PrimeLeadPostbackService::class:
                return new PrimeLeadPostbackServiceConfig();
            case SalesDoublerPostbackService::class:
                return new SalesDoublerPostbackServiceConfig();
        }
        throw new UnsupportedPostbackServiceException($service);
    }

    /**
     * Generates the configuration tree builder.
     *
     * @throws NotImplementedException
     */
    public function getConfigTreeBuilder()
    {
        throw new NotImplementedException();
    }

    /**
     * @throws NotImplementedException
     */
    public function getConfigTreeBuilderRoot(): string
    {
        throw new NotImplementedException();
    }
}