<?php

namespace Wearesho\Cpa\Repository;


use Psr\Http\Message\ResponseInterface;
use Wearesho\Cpa\Interfaces\ConversionInterface;
use Wearesho\Cpa\Interfaces\ConversionRepositoryInterface;
use Wearesho\Cpa\Interfaces\StoredConversionInterface;

/**
 * Class ConversionMemoryRepository
 * @package Wearesho\Cpa
 *
 * This class represents storage for sent conversion.
 * It suitable for tests because it does not store anything as files or in databases.
 */
class ConversionMemoryRepository implements ConversionRepositoryInterface
{
    /** @var StoredConversion[] */
    protected $storage = [];

    /**
     * Saving sent conversion in storage
     *
     * @param ConversionInterface $conversion
     * @param ResponseInterface $response
     *
     * @return StoredConversionInterface
     */
    public function push(ConversionInterface $conversion, ResponseInterface $response): StoredConversionInterface
    {
        $storedConversion = new StoredConversion($conversion, $response);
        return $this->storage[] = $storedConversion;
    }

    /**
     * @param $conversionId
     * @param string $type Class name that extends ConversionInterface
     *
     * @return null|StoredConversionInterface
     */
    public function pull($conversionId, string $type)
    {
        foreach ($this->storage as $storedConversion) {
            if (
                $storedConversion->getConversion()->getId() === $conversionId
                && $storedConversion->getConversion() instanceof $type
            ) {
                return $storedConversion;
            }
        }
    }
}