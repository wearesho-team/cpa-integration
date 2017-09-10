<?php

namespace Wearesho\Cpa\AdmitAd;


use Wearesho\Cpa\Exceptions\UnsupportedLeadException;
use Wearesho\Cpa\Interfaces\LeadFactoryInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;
use Wearesho\Cpa\Lead\AbstractLeadFactory;

/**
 * Class LeadFactory
 * @package Wearesho\Cpa\AdmitAd
 */
class LeadFactory extends AbstractLeadFactory implements LeadFactoryInterface
{
    const UID_FIELD = 'admitad_uid';

    /**
     * @param array $query
     * @return LeadInterface|null
     */
    protected function fromQuery(array $query)
    {
        if (!array_key_exists(static::UID_FIELD, $query)) {
            return null;
        }
        return new Lead($query[static::UID_FIELD]);
    }

    /**
     * @param LeadInterface $lead
     * @throws UnsupportedLeadException
     * @return string
     */
    public function toCookie(LeadInterface $lead): string
    {
        if (!$lead instanceof Lead) {
            throw new UnsupportedLeadException($this, $lead);
        }

        return json_encode([
            static::UID_FIELD => $lead->getUid(),
        ]);
    }
}