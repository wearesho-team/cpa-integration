<?php

namespace Wearesho\Cpa\Interfaces;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface StoredConversionInterface
 * @package Wearesho\Cpa\Interfaces
 *
 * This class represents stored sent conversion in pair with CPA network response
 */
interface StoredConversionInterface
{
    /**
     * @return ConversionInterface
     */
    public function getConversion(): ConversionInterface;

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;
}
