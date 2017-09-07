<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 8:31 AM
 */

namespace Wearesho\Cpa\Exceptions;


use Throwable;
use Wearesho\Cpa\Interfaces\ConversionInterface;
use Wearesho\Cpa\Interfaces\PostbackServiceInterface;

/**
 * Class UnsupportedConversionType
 * @package Wearesho\Cpa\Exceptions
 */
class UnsupportedConversionTypeException extends CpaException
{
    /** @var PostbackServiceInterface */
    protected $postbackService;

    /** @var ConversionInterface */
    protected $conversion;

    public function __construct(
        PostbackServiceInterface $postbackService,
        ConversionInterface $conversion,
        $code = 0, Throwable $previous = null
    )
    {
        $message = get_class($postbackService) . " does not support " . get_class($conversion);
        parent::__construct($message, $code, $previous);

        $this->conversion = $conversion;
        $this->postbackService = $postbackService;
    }

    /**
     * @return ConversionInterface
     */
    public function getConversion(): ConversionInterface
    {
        return $this->conversion;
    }

    /**
     * @return PostbackServiceInterface
     */
    public function getPostbackService(): PostbackServiceInterface
    {
        return $this->postbackService;
    }
}