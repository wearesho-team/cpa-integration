<?php

namespace Wearesho\Cpa\Tests\PostbackServices;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

use Wearesho\Cpa\Exceptions\DuplicatedConversionException;
use Wearesho\Cpa\Exceptions\UnsupportedConversionTypeException;

use Wearesho\Cpa\PrimeLead\Lead;
use Wearesho\Cpa\PrimeLead\Conversion;
use Wearesho\Cpa\PrimeLead\PostbackServiceConfig;
use Wearesho\Cpa\PrimeLead\PostbackService;

use Wearesho\Cpa\SalesDoubler\Lead as SalesDoublerLead;
use Wearesho\Cpa\SalesDoubler\Conversion as SalesDoublerConversion;


/**
 * Class PrimeLeadTest
 * @package Wearesho\Cpa\Tests
 */
class PrimeLeadPostbackServiceTest extends PostbackServiceTestCase
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
        $this->postbackConfig->setBaseUri("https://primeadv.go2cloud.org/test/");

        $this->service = new PostbackService(
            $this->repository,
            $this->postbackConfig,
            $this->client
        );
    }

    public function testUrl()
    {
        $transactionId = 1001;
        $conversionId = 1002;

        $lead = new Lead($transactionId);
        $conversion = new Conversion($lead, $conversionId);

        $requestSent = false;
        $this->client->setClosure(function (RequestInterface $request) use (&$requestSent, $transactionId, $conversionId) {
            $requestSent = true;

            $this->assertEquals(
                "https://primeadv.go2cloud.org/test/"
                . "{$this->postbackConfig->getId()}?adv_sub={$conversionId}&transaction_id={$transactionId}",
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
        $lead = new SalesDoublerLead(1);
        $conversion = new SalesDoublerConversion($lead, 2);

        $this->expectException(UnsupportedConversionTypeException::class);

        $this->service->send($conversion);
    }

    public function testConfigTree()
    {
        $tree = $this->postbackConfig->getConfigTreeBuilder();
        $this->assertInstanceOf(TreeBuilder::class, $tree);
    }
}