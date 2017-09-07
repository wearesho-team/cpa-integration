<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 10:47 AM
 */

namespace Wearesho\Cpa\Tests;


use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\ConversionMemoryRepository;
use Wearesho\Cpa\SalesDoubler\Conversion;
use Wearesho\Cpa\SalesDoubler\Lead;
use Wearesho\Cpa\StoredConversion;

use Wearesho\Cpa\PrimeLead\Conversion as PrimeLeadConversion;

/**
 * Class ConversionMemoryRepositoryTest
 * @package Wearesho\Cpa\Tests
 */
class ConversionMemoryRepositoryTest extends TestCase
{
    public function testPush()
    {
        $repository = new ConversionMemoryRepository();

        $lead = new Lead(1);
        $conversion = new Conversion($lead, 2);

        $pair = $repository->push(
            $conversion,
            $response = new Response()
        );
        $this->assertEquals($conversion, $pair->getConversion());
        $this->assertEquals($response, $pair->getResponse());
    }

    public function testPull()
    {
        $repository = new ConversionMemoryRepository();

        $lead = new Lead(1);
        $conversion = new Conversion($lead, 2);

        $pair = $repository->push(
            $conversion,
            new Response()
        );

        $this->assertInstanceOf(
            StoredConversion::class,
            $repository->pull($conversion->getId(), get_class($conversion)),
            "It must pulls conversion after push"
        );

        $this->assertNull(
            $repository->pull($notPushedId = 3, get_class($conversion)),
            "It must return null if no conversion with specified id found"
        );

        $this->assertNull(
            $repository->pull(
                $pushedId = $conversion->getId(),
                PrimeLeadConversion::class
            ),
            "It must not pull conversion with wrong type"
        );
    }

}