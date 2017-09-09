<?php

namespace Wearesho\Cpa\Exceptions;

use Wearesho\Cpa\Interfaces\LeadFactoryInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;


/**
 * Class UnsupportedLeadException
 * @package Wearesho\Cpa\Exceptions
 */
class UnsupportedLeadException extends CpaException
{
    /** @var LeadFactoryInterface */
    protected $leadFactory;

    /** @var LeadInterface */
    protected $lead;

    public function __construct(
        LeadFactoryInterface $leadFactory,
        LeadInterface $lead,
        $code = 0,
        \Throwable $previous = null
    )
    {
        $message = get_class($leadFactory) . " does not support " . get_class($lead);
        parent::__construct($message, $code, $previous);

        $this->lead = $lead;
        $this->leadFactory = $leadFactory;
    }

    /**
     * @return LeadFactoryInterface
     */
    public function getLeadFactory(): LeadFactoryInterface
    {
        return $this->leadFactory;
    }

    /**
     * @return LeadInterface
     */
    public function getLead(): LeadInterface
    {
        return $this->lead;
    }

}