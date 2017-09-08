<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/8/17
 * Time: 2:43 PM
 */

namespace Wearesho\Cpa\Tests\Factories;


use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\SalesDoubler\Lead;
use Wearesho\Cpa\SalesDoubler\LeadFactory;

class SalesDoublerLeadFactoryTest extends TestCase
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
        $lead = $this->factory->fromUrl('https://google.com/?aff_sub=random');
        $this->assertNull($lead, "Factory should return null if no utm_source provided");
    }

    public function testInvalidUtm()
    {
        $lead = $this->factory->fromUrl('https://google.com/?utm_source=vk&aff_sub=random');
        $this->assertNull($lead, "Factory should return null if invalid utm_source provided");
    }

    public function testMissingClickIdParam()
    {
        $lead = $this->factory->fromUrl('https://google.com/?utm_source=salesdoubler');
        $this->assertNull($lead, "Factory should return null if no click id param (aff_sub) provided");
    }

    public function testValidUrl()
    {
        $affSub = "Random123";
        $lead = $this->factory->fromUrl("https://google.com/?utm_source=salesdoubler&aff_sub={$affSub}");
        $this->assertInstanceOf(
            Lead::class,
            $lead,
            "Factory should generate Lead in case utm_source and aff_sub provided"
        );
        $this->assertEquals(
            $affSub,
            $lead->getClickId(),
            "Factory should pass aff_sub param to Lead::clickId"
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
        $affSub = "%Some%Rnadom";
        $lead = $this->factory->fromCookie('{"utm_source":"salesdoubler","aff_sub":"' . $affSub . '"}');
        $this->assertInstanceOf(
            Lead::class,
            $lead,
            "Factory should generate lead from valid json cookie string"
        );
        $this->assertEquals(
            $affSub,
            $lead->getClickId(),
            "Factory should pass aff_sub from cookie json to Lead::clickId"
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
            "aff_sub",
            $query,
            "Cookie generator should include aff_sub to cookie"
        );

        $this->assertEquals(
            "salesdoubler",
            $query['utm_source'],
            "Cookie generator should include valid utm source"
        );
        $this->assertEquals(
            $lead->getClickId(),
            $query['aff_sub'],
            "Cookie generator should include aff_sub from Lead::clickId "
        );
    }
}