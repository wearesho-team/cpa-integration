<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 9:10 AM
 */

namespace Wearesho\Cpa\PrimeLead;

use Wearesho\Cpa\Interfaces\ConversionInterface;

/**
 * Class Conversion
 * @package Wearesho\Cpa\PrimeLead
 */
class Conversion implements ConversionInterface
{
    /** @var  string */
    protected $id;

    /** @var  Lead */
    protected $lead;

    /**
     * Conversion constructor.
     * @param Lead $lead
     * @param $id
     */
    public function __construct(Lead $lead, string $id)
    {
        $this->lead = $lead;
        $this->id = $id;
    }

    /**
     * Request or registered user id
     *
     * @return string|int
     */
    public function getId(): string
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