<?php

namespace Wearesho\Cpa\Interfaces;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface ConversionFactoryInterface
 * @package Wearesho\Cpa\Interfaces
 */
interface LeadFactoryInterface
{
    /**
     * Parse web request and create lead with common information
     *
     * @param Request $request
     * @return LeadInterface
     */
    public function create(Request $request): LeadInterface;
}