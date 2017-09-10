<?php

namespace Wearesho\Cpa\Loangate;


use Wearesho\Cpa\Interfaces\ConversionInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;

/**
 * Class Conversion
 * @package Wearesho\Cpa\Loangate
 */
class Conversion implements ConversionInterface
{
    const DEFAULT_GOAL = 1;

    /** @var int */
    protected $id;

    /** @var Lead */
    protected $lead;

    /** @var  int */
    protected $goal;

    /**
     * Conversion constructor.
     *
     * @param Lead $lead
     * @param int $id
     * @param int $goal
     */
    public function __construct(Lead $lead, int $id, int $goal = self::DEFAULT_GOAL)
    {
        $this->id = $id;
        $this->lead = $lead;
        $this->goal = $goal;
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
     * @return LeadInterface|Lead
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @return int
     */
    public function getGoal(): int
    {
        return $this->goal;
    }
}