<?php

namespace Wearesho\Cpa;


use Psr\Http\Message\ResponseInterface;
use Wearesho\Cpa\Interfaces\ConversionInterface;
use Wearesho\Cpa\Interfaces\StoredConversionInterface;

/**
 * Class MemoryStoredConversion
 * @package Wearesho\Cpa
 *
 * Simple representation of Conversion-Response pair.
 */
class StoredConversion implements StoredConversionInterface
{
    /** @var ConversionInterface */
    protected $conversion;

    /** @var ResponseInterface */
    protected $response;

    /**
     * MemoryStoredConversion constructor.
     * @param ConversionInterface $conversion
     * @param ResponseInterface $response
     */
    public function __construct(ConversionInterface $conversion, ResponseInterface $response)
    {
        $this->conversion = $conversion;
        $this->response = $response;
    }

    /**
     * @return ConversionInterface
     */
    public function getConversion(): ConversionInterface
    {
        return $this->conversion;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}