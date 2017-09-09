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
     * @param LeadInterface $conversion
     * @return void
     */
    public function push(LeadInterface $conversion);

    /**
     * @return null|LeadInterface
     */
    public function pull();
}