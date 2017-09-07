<?php

namespace Wearesho\Cpa\Interfaces;

use Psr\Http\Message\ResponseInterface;


/**
 * Interface ConversionRepositoryInterface
 * @package Wearesho\Cpa\Interfaces
 *
 * This interface is responsible for storing sent conversions
 * to prevent duplicated sending and building statistics and reports.
 */
interface ConversionRepositoryInterface
{
    /**
     * Saving sent conversion in storage
     *
     * @param ConversionInterface $conversion
     * @param ResponseInterface $response
     *
     * @return StoredConversionInterface
     */
    public function push(ConversionInterface $conversion, ResponseInterface $response): StoredConversionInterface;

    /**
     * @param $conversionId
     * @param string $type Class name that extends ConversionInterface
     *
     * @return null|StoredConversionInterface
     */
    public function pull($conversionId, string $type);
}