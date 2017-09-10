<?php

namespace Wearesho\Cpa\Loangate;


use Wearesho\Cpa\Exceptions\UnsupportedLeadException;
use Wearesho\Cpa\Interfaces\LeadFactoryInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;
use Wearesho\Cpa\Lead\AbstractLeadFactory;

/**
 * Class LeadFactory
 * @package Wearesho\Cpa\Loangate
 */
class LeadFactory extends AbstractLeadFactory implements LeadFactoryInterface
{
    const CLICK_ID_FIELD = "afclick";

    /**
     * @param array $query
     * @return LeadInterface|null
     */
    protected function fromQuery(array $query)
    {
        if (!array_key_exists(static::CLICK_ID_FIELD, $query)) {
            return null;
        }
        return new Lead($query[static::CLICK_ID_FIELD]);
    }

    /**
     * @param LeadInterface|Lead $lead
     * @throws UnsupportedLeadException
     * @return string
     */
    public function toCookie(LeadInterface $lead): string
    {
        if (!$lead instanceof Lead) {
            throw new UnsupportedLeadException($this, $lead);
        }

        return json_encode([
            static::CLICK_ID_FIELD => $lead->getClickId(),
        ]);
    }
}