<?php

namespace Wearesho\Cpa\PrimeLead;


use Wearesho\Cpa\Interfaces\LeadInterface;

/**
 * Class Lead
 * @package Wearesho\Cpa\PrimeLead
 */
class Lead implements LeadInterface
{
    /** @var string  */
    protected $transactionId;

    /**
     * Lead constructor.
     * @param string $transactionId
     */
    public function __construct(string $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }
}