<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/8/17
 * Time: 4:48 PM
 */

namespace Wearesho\Cpa\Tests\Leads;


use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\SalesDoubler\Conversion;
use Wearesho\Cpa\SalesDoubler\Lead;

/**
 * Class SalesDoublerLeadTest
 * @package Wearesho\Cpa\Tests\Leads
 */
class SalesDoublerLeadTest extends TestCase
{
    public function testGeneratingConversion()
    {
        $lead = new Lead(1);
        $conversionId = mt_rand();
        $conversion = $lead->createConversion($conversionId);
        $this->assertInstanceOf(
            Conversion::class,
            $conversion,
            "It should generate SalesDoubler conversion"
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