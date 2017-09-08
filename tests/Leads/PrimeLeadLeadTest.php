<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/8/17
 * Time: 4:50 PM
 */

namespace Wearesho\Cpa\Tests\Leads;

use PHPUnit\Framework\TestCase;

use Wearesho\Cpa\PrimeLead\Lead;
use Wearesho\Cpa\PrimeLead\Conversion;

class PrimeLeadLeadTest extends TestCase
{
    public function testGeneratingConversion()
    {
        $lead = new Lead(1);
        $conversionId = mt_rand();
        $conversion = $lead->createConversion($conversionId);
        $this->assertInstanceOf(
            Conversion::class,
            $conversion,
            "It should generate PrimeLead conversion"
        );
        $this->assertEquals(
            $conversionId,
            $conversion->getId(),
            "It should pass conversionId argument into Conversion::id"
        );
        $this->assertEquals(
            $lead,
            $conversion->getLead(),
            "It should pass itself into Conversion::lead"
        );
    }
}