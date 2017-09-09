<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/9/17
 * Time: 2:45 PM
 */

namespace Wearesho\Cpa\Tests\PostbackServices;


use GuzzleHttp\Psr7\Response;
use Wearesho\Cpa\Exceptions\UnsupportedConfigException;

use Wearesho\Cpa\Exceptions\UnsupportedConversionTypeException;
use Wearesho\Cpa\Postback\PostbackService;
use Wearesho\Cpa\Postback\PostbackServiceConfig;

use Wearesho\Cpa\SalesDoubler\Lead as SalesDoublerLead;
use Wearesho\Cpa\SalesDoubler\Conversion as SalesDoublerConversion;
use Wearesho\Cpa\SalesDoubler\PostbackService as SalesDoublerPostbackService;
use Wearesho\Cpa\SalesDoubler\PostbackServiceConfig as SalesDoublerPostbackServiceConfig;

use Wearesho\Cpa\PrimeLead\Lead as PrimeLeadLead;
use Wearesho\Cpa\PrimeLead\Conversion as PrimeLeadConversion;

/**
 * Class CommonPostbackServiceTest
 * @package Wearesho\Cpa\Tests\PostbackServices
 */
class CommonPostbackServiceTest extends PostbackServiceTestCase
{
    /** @var  PostbackServiceConfig */
    protected $postbackConfig;

    /** @var  PostbackService */
    protected $service;

    /** @var  SalesDoublerPostbackService */
    protected $childService;

    protected $childConversion;

    protected function setUp()
    {
        parent::setUp();

        $this->childService = new SalesDoublerPostbackService(
            $this->repository,
            $this->client
        );
        $this->childConversion = new SalesDoublerConversion(
            new SalesDoublerLead(1),
            1
        );

        $this->postbackConfig = new PostbackServiceConfig();
        $this->service = new PostbackService(
            $this->repository,
            $this->client,
            $this->postbackConfig,
            [$this->childService]
        );
    }

    public function testSettingInvalidConfig()
    {
        $this->service->setConfig($config = new PostbackServiceConfig());
        $this->assertEquals(
            $config,
            $this->service->getConfig(),
            "Getter must return same instance passed to setter"
        );
        $this->expectException(UnsupportedConfigException::class);
        $this->service->setConfig(new SalesDoublerPostbackServiceConfig());
    }

    public function testSkippingNotConfiguredService()
    {
        $this->postbackConfig->setConfig(['salesdoubler' => false]);
        $this->expectException(UnsupportedConversionTypeException::class);
        $this->service->send($this->childConversion);
    }

    public function testConfiguringChildService()
    {
        $this->postbackConfig->setConfig($salesDoublerConfig = $this->getValidSalesDoublerConfig());
        $conversionSent = false;
        $this->client->setClosure(function () use (&$conversionSent) {
            $conversionSent = true;
            return new Response();
        });
        $this->service->send($this->childConversion);
        $this->assertTrue(
            $conversionSent,
            "Conversion must be sent by child service"
        );

        /** @var SalesDoublerPostbackServiceConfig $childConfig */
        $childConfig = $this->childService->getConfig();
        $this->assertInstanceOf(
            SalesDoublerPostbackServiceConfig::class,
            $childConfig,
            "It should configure child service from provided array"
        );
        $this->assertEquals(
            $salesDoublerConfig['SalesDoubler']['id'],
            $childConfig->getId(),
            "It should correctly configure SalesDoublerPostbackServiceConfig::id"
        );
        $this->assertEquals(
            $salesDoublerConfig['SalesDoubler']['token'],
            $childConfig->getToken(),
            "It should correctly configure SalesDoublerPostbackServiceConfig::token"
        );
        $this->assertEquals(
            $salesDoublerConfig['SalesDoubler']['baseUrl'],
            $childConfig->getBaseUrl(),
            "It should correctly configure SalesDoublerPostbackServiceConfig::baseUrl"
        );
    }

    public function testConfiguringConfiguredChildService()
    {
        $this->postbackConfig->setConfig($this->getValidSalesDoublerConfig());

        $childConfig = new SalesDoublerPostbackServiceConfig();
        $childConfig->setId(mt_rand());
        $childConfig->setToken(mt_rand());
        $childConfig->setBaseUrl('https://wearesho.com/');
        $this->childService->setConfig($childConfig);

        $this->service->send($this->childConversion);
        $this->assertEquals(
            $childConfig,
            $this->childService->getConfig(),
            "It should not reconfigure configured child service"
        );
    }

    public function testSkippingWrongChildServices()
    {
        $this->postbackConfig->setConfig($this->getValidSalesDoublerConfig());

        $exceptionCaught = false;
        $unsupportedConversion = new PrimeLeadConversion(new PrimeLeadLead(1), 1);
        try {
            $this->service->send($unsupportedConversion);
        } catch (UnsupportedConversionTypeException $ex) {
            $exceptionCaught = true;
            $this->assertEquals(
                $this->service,
                $ex->getPostbackService(),
                "Exception must be threw by common service, child exceptions must be caught"
            );
            $this->assertEquals(
                $unsupportedConversion,
                $ex->getConversion(),
                "Unsupported conversion must be passed to exception constructor"
            );
        }
        $this->assertTrue(
            $exceptionCaught,
            "UnsupportedConversionTypeException must be threw when conversion not supported by each child service"
        );

    }

    protected function getValidSalesDoublerConfig(): array
    {
        return [
            'SalesDoubler' => [
                'id' => mt_rand(),
                'token' => mt_rand(),
                'baseUrl' => 'https://wearesho.com/' . mt_rand() . '/',
            ],
        ];
    }
}