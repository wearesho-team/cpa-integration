<?php

namespace Wearesho\Cpa\Loangate;


use Wearesho\Cpa\Interfaces\ConversionInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;

/**
 * Class Lead
 * @package Wearesho\Cpa\Loangate
 */
class Lead implements LeadInterface
{

    /** @var  string */
    protected $clickId;

    /**
     * Lead constructor.
     * @param string $clickId
     */
    public function __construct(string $clickId)
    {
        $this->clickId = $clickId;
    }

    /**
     * @return string
     */
    public function getClickId(): string
    {
        return $this->clickId;
    }

    /**
     * @param string $conversionId
     * @param int $goal
     * @return ConversionInterface
     */
    public function createConversion(string $conversionId, int $goal = Conversion::DEFAULT_GOAL): ConversionInterface
    {
        return new Conversion($this, $conversionId, $goal);
    }
}