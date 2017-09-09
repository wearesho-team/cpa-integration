<?php

namespace Wearesho\Cpa\Lead;


use Wearesho\Cpa\Exceptions\UnsupportedLeadException;
use Wearesho\Cpa\Interfaces\LeadFactoryInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;

use Wearesho\Cpa\PrimeLead\LeadFactory as PrimeLeadLeadFactory;
use Wearesho\Cpa\SalesDoubler\LeadFactory as SalesDoublerLeadFactory;

/**
 * Class LeadFactory
 * @package Wearesho\Cpa
 *
 * This factory is designed to use list of factories to get Lead
 */
class LeadFactory implements LeadFactoryInterface
{
    /** @var  LeadFactoryInterface[] */
    public $factories;

    /**
     * LeadFactory constructor.
     * @param array $factories
     */
    public function __construct(array $factories = null)
    {
        if (is_null($factories)) {
            $factories = [
                new SalesDoublerLeadFactory(),
                new PrimeLeadLeadFactory(),
            ];
        }
        $this->factories = $factories;
    }

    /**
     * Parse request url and create lead with common information
     *
     * @param string $requestUrl
     * @return LeadInterface|null
     */
    public function fromUrl(string $requestUrl)
    {
        return array_reduce(
            $this->factories,
            function ($lead, LeadFactoryInterface $factory) use ($requestUrl) {
                return $lead ?? $factory->fromUrl($requestUrl);
            }
        );
    }

    /**
     * Parse cookies
     *
     * @param string $cookie
     * @return LeadInterface|null
     */
    public function fromCookie(string $cookie)
    {
        return array_reduce(
            $this->factories,
            function ($lead, LeadFactoryInterface $factory) use ($cookie) {
                return $lead ?? $factory->fromCookie($cookie);
            }
        );
    }

    /**
     * @param LeadInterface $lead
     * @throws UnsupportedLeadException
     * @return string
     */
    public function toCookie(LeadInterface $lead): string
    {
        foreach ($this->factories as $factory) {
            try {
                return $factory->toCookie($lead);
            } catch (UnsupportedLeadException $unsupportedLeadException) {
            }
        }
        throw new UnsupportedLeadException($this, $lead);
    }
}