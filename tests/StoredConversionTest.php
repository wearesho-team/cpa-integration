<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 11:01 AM
 */

namespace Wearesho\Cpa\Tests;


use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\PrimeLead\Conversion;
use Wearesho\Cpa\PrimeLead\Lead;
use Wearesho\Cpa\StoredConversion;

class StoredConversionTest extends TestCase
{
    public function testGetters()
    {
        $lead = new Lead(1);
        $conversion = new Conversion($lead, 2);
        $response = new Response(201);

        $pair = new StoredConversion($conversion, $response);
        $this->assertEquals($conversion, $pair->getConversion());
        $this->assertEquals($response, $pair->getResponse());
    }
}