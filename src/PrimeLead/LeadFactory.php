<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 1:28 PM
 */

namespace Wearesho\Cpa\PrimeLead;


use Wearesho\Cpa\Lead\AbstractLeadFactory;
use Wearesho\Cpa\Exceptions\UnsupportedLeadException;
use Wearesho\Cpa\Interfaces\LeadFactoryInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;

/**
 * Class LeadFactory
 * @package Wearesho\Cpa\PrimeLead
 *
 * @method Lead fromUrl(string $url)
 * @method Lead fromCookie(string $cookie)
 */
class LeadFactory extends AbstractLeadFactory implements LeadFactoryInterface
{
    const UTM_SOURCE = 'primelead';
    const TRANSACTION_ID_PARAM = 'transaction_id';

    /**
     * @param Lead|LeadInterface $lead
     * @throws UnsupportedLeadException
     * @return string
     */
    public function toCookie(LeadInterface $lead): string
    {
        if (!$lead instanceof Lead) {
            throw new UnsupportedLeadException($this, $lead);
        }

        return json_encode([
            'utm_source' => static::UTM_SOURCE,
            static::TRANSACTION_ID_PARAM => $lead->getTransactionId(),
        ]);
    }

    /**
     * @param array $query
     * @return LeadInterface|null
     */
    protected function fromQuery(array $query)
    {
        if (
            !array_key_exists('utm_source', $query)
            || !array_key_exists(static::TRANSACTION_ID_PARAM, $query)
            || $query['utm_source'] !== static::UTM_SOURCE
        ) {
            return null;
        }
        return new Lead($query[static::TRANSACTION_ID_PARAM]);
    }
}