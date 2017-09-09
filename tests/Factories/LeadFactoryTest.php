<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/8/17
 * Time: 4:03 PM
 */

namespace Wearesho\Cpa\Tests\Factories;


use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\Exceptions\UnsupportedLeadException;
use Wearesho\Cpa\Lead\LeadFactory;
use Wearesho\Cpa\PrimeLead\Lead as PrimeLeadLead;

class LeadFactoryTest extends TestCase
{
    /** @var LeadFactory */
    protected $factory;

    protected function setUp()
    {
        parent::setUp();
        $this->factory = new LeadFactory();
    }

    public function testFromUrlNotMatch()
    {
        $this->factory->factories = [];
        $lead = $this->factory->fromUrl('');
        $this->assertNull($lead, "It should return null if all factories returned null");
    }

    public function testFromUrlMatch()
    {
        $lead = $this->factory->fromUrl("https://google.com/?utm_source=primelead&transaction_id=0");
        $this->assertInstanceOf(
            PrimeLeadLead::class,
            $lead,
            "It should return match if child factory return it"
        );
    }

    public function testFromCookieNotMatch()
    {
        $lead = $this->factory->fromCookie('');
        $this->assertNull($lead, "It should return null if all factories returned null");
    }

    public function testFromCookieMatch()
    {
        $lead = $this->factory->fromCookie('{"utm_source":"primelead","transaction_id":1}');
        $this->assertInstanceOf(
            PrimeLeadLead::class,
            $lead,
            "It should return match if child factory returned it"
        );
    }

    public function testToCookieException()
    {
        $this->expectException(UnsupportedLeadException::class);
        $this->factory->factories = [];
        $this->factory->toCookie(new PrimeLeadLead(1));
    }

    public function testToCookie()
    {
        $cookie = $this->factory->toCookie(new PrimeLeadLead(1));
        $this->assertNotNull(
            $cookie,
            "It should return cookie string if one of child factories generate it"
        );
    }

    public function testConstructor()
    {
        $factories = [];
        $factory = new LeadFactory($factories);
        $this->assertEquals(
            $factories,
            $factory->factories,
            "It should set factories from constructor argument, even when it is empty array"
        );

        $factories = null;
        $factory = new LeadFactory($factories);
        $this->assertGreaterThan(
            0,
            count($factory->factories),
            "It should set all factories if null provided as factories constructor argument or no argument provided"
        );
    }
}