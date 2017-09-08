<?php

namespace Wearesho\Cpa\Interfaces;

/**
 * Interface ConversionFactoryInterface
 * @package Wearesho\Cpa\Interfaces
 */
interface LeadFactoryInterface
{
    /**
     * Parse request url and create lead with common information
     *
     * @param string $requestUrl
     * @return LeadInterface|null
     */
    public function fromUrl(string $requestUrl);

    /**
     * Parse cookies
     *
     * @param string $cookie
     * @return LeadInterface|null
     */
    public function fromCookie(string $cookie);

    /**
     * @param LeadInterface $lead
     * @return string
     */
    public function toCookie($lead): string;
}