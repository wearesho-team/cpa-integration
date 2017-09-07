<?php

namespace Wearesho\Cpa\Exceptions;

use Throwable;
use Wearesho\Cpa\Interfaces\ConversionInterface;

/**
 * Class DuplicatedConversionException
 * @package Wearesho\Cpa\Exceptions
 */
class DuplicatedConversionException extends CpaException
{
    /** @var ConversionInterface */
    protected $conversion;

    /**
     * DuplicatedConversionException constructor.
     * @param ConversionInterface $conversion
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(ConversionInterface $conversion, $code = 0, Throwable $previous = null)
    {
        $message = "Conversion " . get_class($conversion) . " with id {$conversion->getId()} already sent";
        parent::__construct($message, $code, $previous);

        $this->conversion = $conversion;
    }

    /**
     * @return ConversionInterface
     */
    public function getConversion(): ConversionInterface
    {
        return $this->conversion;
    }
}