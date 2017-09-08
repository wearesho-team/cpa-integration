<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 10:00 AM
 */

namespace Wearesho\Cpa\Tests\PostbackServices;

use GuzzleHttp\Psr7\Response;

use Psr\Http\Message\RequestInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Wearesho\Cpa\Exceptions\DuplicatedConversionException;
use Wearesho\Cpa\Exceptions\UnsupportedConversionTypeException;
use Wearesho\Cpa\SalesDoubler\PostbackServiceConfig;
use Wearesho\Cpa\SalesDoubler\Conversion;
use Wearesho\Cpa\SalesDoubler\Lead;
use Wearesho\Cpa\SalesDoubler\PostbackService;

use Wearesho\Cpa\PrimeLead\Lead as PrimeLeadLead;
use Wearesho\Cpa\PrimeLead\Conversion as PrimeLeadConversion;

/**
 * Class SalesDoublerTestCase
 * @package Wearesho\Cpa\Tests
 */
class SalesDoublerPostbackServiceTest extends PostbackServiceTestCase
{
    /** @var  PostbackServiceConfig */
    protected $postbackConfig;

    /** @var  PostbackService */
    protected $service;

    protected function setUp()
    {
        parent::setUp();

        $this->postbackConfig = new PostbackServiceConfig();
        $this->postbackConfig->setId(mt_rand());
        $this->postbackConfig->setToken(mt_rand());
        $this->postbackConfig->setBaseUri("http://rdr.salesdoubler.com.ua/test/");

        $this->service = new PostbackService(
            $this->repository,
            $this->postbackConfig,
            $this->client
        );
    }

    public function testUrl()
    {
        $clickId = 1001;
        $conversionId = 1002;

        $lead = new Lead($clickId);
        $conversion = new Conversion($lead, $conversionId);

        $requestSent = false;
        $this->client->setClosure(function (RequestInterface $request) use (&$requestSent, $clickId, $conversionId) {
            $requestSent = true;

            $this->assertEquals(
                "http://rdr.salesdoubler.com.ua/test/"
                . "in/postback/{$this->postbackConfig->getId()}/{$clickId}"
                . "?trans_id={$conversionId}&token={$this->postbackConfig->getToken()}",
                $request->getUri(),
                "Request must have correct URI"
            );

            return new Response();
        });

        $this->service->send($conversion);
        $this->assertTrue($requestSent, "Request must be send");
    }

    public function testDuplicatedRequest()
    {
        $lead = new Lead(1003);
        $conversion = new Conversion($lead, 1004);

        $this->repository->push($conversion, new Response());
        $this->expectException(DuplicatedConversionException::class);

        $this->service->send($conversion);
    }

    public function testInvalidConversionType()
    {
        $lead = new PrimeLeadLead(1);
        $conversion = new PrimeLeadConversion($lead, 2);

        $this->expectException(UnsupportedConversionTypeException::class);

        $this->service->send($conversion);
    }

    public function testConfigTree()
    {
        $tree = $this->postbackConfig->getConfigTreeBuilder();
        $this->assertInstanceOf(TreeBuilder::class, $tree);
    }
}