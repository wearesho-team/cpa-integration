<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/10/17
 * Time: 9:56 AM
 */

namespace Wearesho\Cpa\Lead;


use Wearesho\Cpa\Interfaces\LeadInterface;
use Wearesho\Cpa\Interfaces\LeadRepositoryInterface;

/**
 * Class LeadMemoryRepository
 * @package Wearesho\Cpa\Lead
 *
 * This class represents storage for current user lead.
 * It suitable for tests because it does not store anything as files or in databases.
 */
class LeadMemoryRepository implements LeadRepositoryInterface
{

    /** @var  LeadInterface */
    protected $lead;

    /**
     * Saving sent conversion in storage
     *
     * @param LeadInterface $lead
     * @return void
     */
    public function push(LeadInterface $lead)
    {
        $this->lead = $lead;
    }

    /**
     * @return null|LeadInterface
     */
    public function pull()
    {
        return $this->lead;
    }
}