<?php

namespace Wearesho\Cpa\Exceptions;


use Throwable;
use Wearesho\Cpa\Interfaces\PostbackServiceInterface;

/**
 * Class UnsupportedPostbackServiceException
 * @package Wearesho\Cpa\Exceptions
 */
class UnsupportedPostbackServiceException extends CpaException
{
    /** @var PostbackServiceInterface */
    protected $service;

    /**
     * UnsupportedPostbackServiceException constructor.
     * @param PostbackServiceInterface $service
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(PostbackServiceInterface $service, $code = 0, Throwable $previous = null)
    {
        $message = "Common PostbackServiceConfig can not instantiate config for " . get_class($service);
        parent::__construct($message, $code, $previous);

        $this->service = $service;
    }

    /**
     * @return PostbackServiceInterface
     */
    public function getService(): PostbackServiceInterface
    {
        return $this->service;
    }
}