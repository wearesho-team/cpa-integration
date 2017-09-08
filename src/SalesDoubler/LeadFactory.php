<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 12:18 PM
 */

namespace Wearesho\Cpa\SalesDoubler;

use Wearesho\Cpa\AbstractLeadFactory;
use Wearesho\Cpa\Exceptions\UnsupportedLeadException;
use Wearesho\Cpa\Interfaces\LeadFactoryInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;

/**
 * Class LeadFactory
 * @package Wearesho\Cpa\SalesDoubler
 *
 * @method Lead fromUrl(string $url)
 * @method Lead fromCookie(string $cookie)
 */
class LeadFactory extends AbstractLeadFactory implements LeadFactoryInterface
{
    const CLICK_ID_PARAM = 'aff_sub';
    const UTM_SOURCE = 'salesdoubler';

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
            static::CLICK_ID_PARAM => $lead->getClickId(),
        ]);
    }

    /**
     * @param array $query
     * @return null|Lead
     */
    protected function fromQuery(array $query)
    {
        if (
            !array_key_exists('utm_source', $query)
            || !array_key_exists(static::CLICK_ID_PARAM, $query)
            || $query['utm_source'] !== static::UTM_SOURCE
        ) {
            return null;
        }

        return new Lead($query[static::CLICK_ID_PARAM]);
    }
}