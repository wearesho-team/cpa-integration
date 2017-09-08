<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/8/17
 * Time: 3:22 PM
 */

namespace Wearesho\Cpa\Tests\Factories;


use PHPUnit\Framework\TestCase;

use Wearesho\Cpa\PrimeLead\LeadFactory;
use Wearesho\Cpa\PrimeLead\Lead;

class PrimeLeadLeadFactoryTest extends TestCase
{
    /** @var LeadFactory */
    protected $factory;

    protected function setUp()
    {
        parent::setUp();
        $this->factory = new LeadFactory();
    }

    public function testWithoutUtm()
    {
        $lead = $this->factory->fromUrl('https://google.com/?transaction_id=random');
        $this->assertNull($lead, "Factory should return null if no utm_source provided");
    }

    public function testInvalidUtm()
    {
        $lead = $this->factory->fromUrl('https://google.com/?utm_source=vk&transaction_id=random');
        $this->assertNull($lead, "Factory should return null if invalid utm_source provided");
    }

    public function testMissingTransactionId()
    {
        $lead = $this->factory->fromUrl('https://google.com/?utm_source=primelead');
        $this->assertNull($lead, "Factory should return null if transaction id param provided");
    }

    public function testValidUrl()
    {
        $transactionId = "Random123";
        $lead = $this->factory->fromUrl("https://google.com/?utm_source=primelead&transaction_id={$transactionId}");
        $this->assertInstanceOf(
            Lead::class,
            $lead,
            "Factory should generate Lead in case utm_source and transaction_id provided"
        );
        $this->assertEquals(
            $transactionId,
            $lead->getTransactionId(),
            "Factory should pass transaction_id param to Lead::transactionId"
        );
    }

    public function testInvalidUrl()
    {
        $lead = $this->factory->fromUrl("asldjnalskdjhtpts://123132.sdaa?asd1293#@");
        $this->assertNull($lead, "Factory should not generate lead from invalid url");
    }

    public function testInvalidCookie()
    {
        $lead = $this->factory->fromCookie('%%{"a": "b"}');
        $this->assertNull($lead, "Factory should not generate lead from invalid cookie json");
    }

    public function testValidCookie()
    {
        $transactionId = "%Some%Rnadom";
        $lead = $this->factory->fromCookie('{"utm_source":"primelead","transaction_id":"' . $transactionId . '"}');
        $this->assertInstanceOf(
            Lead::class,
            $lead,
            "Factory should generate lead from valid json cookie string"
        );
        $this->assertEquals(
            $transactionId,
            $lead->getTransactionId(),
            "Factory should pass transaction_id from cookie json to Lead::transactionId"
        );
    }

    public function testCookieGeneration()
    {
        $lead = new Lead(mt_rand());
        $cookie = $this->factory->toCookie($lead);
        $query = json_decode($cookie, true);

        $this->assertEquals(
            JSON_ERROR_NONE,
            json_last_error(),
            "Cookie generator must return valid json"
        );

        $this->assertArrayHasKey(
            "utm_source",
            $query,
            "Cookie generator should include utm source to cookie"
        );
        $this->assertArrayHasKey(
            "transaction_id",
            $query,
            "Cookie generator should include transaction_id to cookie"
        );

        $this->assertEquals(
            "primelead",
            $query['utm_source'],
            "Cookie generator should include valid utm source"
        );
        $this->assertEquals(
            $lead->getTransactionId(),
            $query['transaction_id'],
            "Cookie generator should include transaction_id from Lead::clickId "
        );
    }
}