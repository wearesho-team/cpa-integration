<?php

namespace Wearesho\Cpa\Interfaces;

/**
 * Interface LeadRepositoryInterface
 * @package Wearesho\Cpa\Interfaces
 *
 * This class represent lead storage across requests (in session, database etc.)
 */
interface LeadRepositoryInterface
{
    /**
     * Saving sent conversion in storage
     *
     * @param LeadInterface $lead
     * @return void
     */
    public function push(LeadInterface $lead);

    /**
     * @return null|LeadInterface
     */
    public function pull();
}