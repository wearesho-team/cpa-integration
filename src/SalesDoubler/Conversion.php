<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 8:20 AM
 */

namespace Wearesho\Cpa\SalesDoubler;


use Wearesho\Cpa\Interfaces\ConversionInterface;

/**
 * Class Conversion
 * @package Wearesho\Cpa\SalesDoubler
 */
class Conversion implements ConversionInterface
{
    /** @var  mixed */
    protected $id;

    /** @var  Lead */
    protected $lead;

    /**
     * Conversion constructor.
     * @param Lead $lead
     * @param $id
     */
    public function __construct(Lead $lead, $id)
    {
        $this->lead = $lead;
        $this->id = $id;
    }

    /**
     * Request or registered user id
     *
     * @return string|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Common information for CPA network
     *
     * @return Lead
     */
    public function getLead(): Lead
    {
        return $this->lead;
    }
}