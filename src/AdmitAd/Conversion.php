<?php

namespace Wearesho\Cpa\AdmitAd;


use Wearesho\Cpa\Interfaces\ConversionInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;

/**
 * Class Conversion
 * @package Wearesho\Cpa\AdmitAd
 */
class Conversion implements ConversionInterface
{
    /** @var Lead */
    protected $lead;

    /** @var int */
    protected $id;

    /** @var int */
    protected $sum;

    /**
     * Conversion constructor.
     *
     * @param Lead $lead
     * @param int $id
     * @param int $sum
     */
    public function __construct(Lead $lead, int $id, int $sum)
    {
        $this->lead = $lead;
        $this->id = $id;
    }

    /**
     * Request or registered user id
     *
     * @return string|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Common information for CPA network
     *
     * @return LeadInterface
     */
    public function getLead()
    {
        return $this->lead;
    }
}