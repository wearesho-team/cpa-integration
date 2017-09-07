<?php

namespace Wearesho\Cpa\Interfaces;


/**
 * Interface ConversionInterface
 * @package Wearesho\Cpa\Interfaces
 *
 * Conversion includes lead (information from cpa network)
 * and contains information about current service used (for example request or registered user id)
 */
interface ConversionInterface
{
    /**
     * Request or registered user id
     *
     * @return string|int
     */
    public function getId();

    /**
     * Common information for CPA network
     *
     * @return LeadInterface
     */
    public function getLead();
}