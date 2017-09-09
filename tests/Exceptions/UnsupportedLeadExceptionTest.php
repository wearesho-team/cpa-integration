<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/9/17
 * Time: 5:55 PM
 */

namespace Wearesho\Cpa\Tests\Exceptions;


use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\Exceptions\UnsupportedLeadException;
use Wearesho\Cpa\PrimeLead\LeadFactory as PrimeLeadLeadFactory;
use Wearesho\Cpa\SalesDoubler\Lead as SalesDoublerLead;

class UnsupportedLeadExceptionTest extends TestCase
{
    public function testMessageAndGetters()
    {
        $exception = new UnsupportedLeadException(
            $factory = new PrimeLeadLeadFactory(),
            $lead = new SalesDoublerLead(mt_rand())
        );

        $this->assertContains(
            get_class($factory),
            $exception->getMessage(),
            "Exception message should contain factory class name"
        );
        $this->assertContains(
            get_class($lead),
            $exception->getMessage(),
            "Exception message should contain lead class name"
        );

        $this->assertEquals(
            $factory,
            $exception->getLeadFactory(),
            "Lead factory getter must return lead factory instance passed to constructor"
        );
        $this->assertEquals(
            $lead,
            $exception->getLead(),
            "Lead getter must return lead instance passed to constructor"
        );
    }
}