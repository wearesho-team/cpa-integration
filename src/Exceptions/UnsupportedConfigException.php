<?php

namespace Wearesho\Cpa\Exceptions;


use Throwable;
use Wearesho\Cpa\Interfaces\PostbackServiceConfigInterface;
use Wearesho\Cpa\Interfaces\PostbackServiceInterface;

/**
 * Class UnsupportedConfigException
 * @package Wearesho\Cpa\Exceptions
 */
class UnsupportedConfigException extends CpaException
{
    /** @var PostbackServiceConfigInterface  */
    protected $config;

    /** @var PostbackServiceInterface  */
    protected $service;

    public function __construct(PostbackServiceInterface $service, PostbackServiceConfigInterface $config, $code = 0, Throwable $previous = null)
    {
        $message = get_class($service) . " does not support " . get_class($config);
        parent::__construct($message, $code, $previous);

        $this->config = $config;
        $this->service = $service;
    }

    /**
     * @return PostbackServiceConfigInterface
     */
    public function getConfig(): PostbackServiceConfigInterface
    {
        return $this->config;
    }

    /**
     * @return PostbackServiceInterface
     */
    public function getService(): PostbackServiceInterface
    {
        return $this->service;
    }
}