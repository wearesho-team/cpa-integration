<?php

namespace Wearesho\Cpa\AdmitAd;

use Wearesho\Cpa\Interfaces\ConversionInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;

/**
 * Class Lead
 * @package Wearesho\Cpa\AdmitAd
 */
class Lead implements LeadInterface
{

    /** @var  string */
    protected $uid;

    /**
     * Lead constructor.
     * @param string $uid
     */
    public function __construct(string $uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @param string $conversionId
     * @param int $sum
     * @return ConversionInterface
     */
    public function createConversion(string $conversionId, int $sum = 0): ConversionInterface
    {
        return new Conversion($this, $conversionId, $sum);
    }
}