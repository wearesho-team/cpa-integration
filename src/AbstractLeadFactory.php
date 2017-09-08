<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 1:23 PM
 */

namespace Wearesho\Cpa;


use Wearesho\Cpa\Interfaces\LeadFactoryInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;

/**
 * Class AbstractLeadFactory
 * @package Wearesho\Cpa
 */
abstract class AbstractLeadFactory implements LeadFactoryInterface
{
    /**
     * Parse web request and create lead with common information
     *
     * @param string $requestUrl
     * @return LeadInterface|null
     */
    public function fromUrl(string $requestUrl)
    {
        parse_str(parse_url($requestUrl)["query"], $query);
        return $this->fromQuery($query);
    }

    /**
     * @param string $cookie
     * @return LeadInterface|null
     */
    public function fromCookie(string $cookie)
    {
        $query = json_decode($cookie, true);
        if (
            json_last_error() !== JSON_ERROR_NONE
            || !is_array($query)
        ) {
            return null;
        }
        return $this->fromQuery($query);
    }

    /**
     * @param array $query
     * @return LeadInterface|null
     */
    abstract protected function fromQuery(array $query);
}