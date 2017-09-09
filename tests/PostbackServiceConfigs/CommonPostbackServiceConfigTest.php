<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/9/17
 * Time: 3:50 PM
 */

namespace Wearesho\Cpa\Tests\PostbackServiceConfigs;


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

use Wearesho\Cpa\Exceptions\NotImplementedException;
use Wearesho\Cpa\Exceptions\UnsupportedPostbackServiceException;
use Wearesho\Cpa\Postback\PostbackService;
use Wearesho\Cpa\Postback\PostbackServiceConfig;

use Wearesho\Cpa\PrimeLead\PostbackService as PrimeLeadPostbackService;
use Wearesho\Cpa\PrimeLead\PostbackServiceConfig as PrimeLeadPostbackServiceConfig;
use Wearesho\Cpa\Repository\ConversionMemoryRepository;

class CommonPostbackServiceConfigTest extends TestCase
{
    /** @var  PostbackServiceConfig */
    protected $config;

    /** @var  PrimeLeadPostbackService */
    protected $service;

    protected function setUp()
    {
        parent::setUp();
        $this->config = new PostbackServiceConfig();
        $this->service = new PrimeLeadPostbackService(
            $repository = new ConversionMemoryRepository(),
            $client = new Client()
        );
    }

    public function testSettingConfiguration()
    {
        $this->assertEquals(
            $defaultArray = [],
            $this->config->getConfig(),
            "Config getter should return array set from constructor (empty by-default)"
        );
        $this->config->setConfig($newArray = [mt_rand() => mt_rand()]);
        $this->assertEquals(
            $newArray,
            $this->config->getConfig(),
            "Config getter should return array set from setter"
        );
    }

    public function testGettingConfigInstances()
    {
        $configInstance = $this->config->getConfigInstance($this->service);
        $this->assertInstanceOf(
            PrimeLeadPostbackServiceConfig::class,
            $configInstance,
            "getConfigInstance must return supported config for PrimeLeadPostbackService"
        );

        $this->expectException(UnsupportedPostbackServiceException::class);
        $this->config->getConfigInstance(
            new PostbackService(
                new ConversionMemoryRepository(),
                new Client()
            )
        );
    }

    public function testConfigTreeBuilder()
    {
        $this->expectException(NotImplementedException::class);
        $this->config->getConfigTreeBuilder();
    }

    public function testConfigTreeBuilderRoot()
    {
        $this->expectException(NotImplementedException::class);
        $this->config->getConfigTreeBuilderRoot();
    }

    public function testMissingConfig()
    {
        $configInstance = $this->config->getConfiguredConfigInstance($this->service);
        $this->assertNull(
            $configInstance,
            "Config instance should not be generated in case config[config-tree-builder-root] is missing"
        );
    }

    public function testConfiguring()
    {
        $configInstance = $this->config->getConfigInstance($this->service);
        $config = [
            $configInstance->getConfigTreeBuilderRoot() => [
                'baseUrl' => $baseUrl = 'https://wearesho.com/' . mt_rand() . '/',
                'id' => $id = mt_rand(),
            ],
        ];
        $this->config->setConfig($config);

        /** @var PrimeLeadPostbackServiceConfig $configInstance */
        $configInstance = $this->config->getConfiguredConfigInstance($this->service);

        $this->assertInstanceOf(
            PrimeLeadPostbackServiceConfig::class,
            $configInstance,
            "Config should configure supportable config class"
        );
        $this->assertEquals(
            $baseUrl,
            $configInstance->getBaseUrl(),
            "Config should configure baseUrl for PrimeLeadPostbackServiceConfig"
        );
        $this->assertEquals(
            $id,
            $configInstance->getId(),
            "Config should configure id for PrimeLeadPostbackServiceConfig"
        );
    }
}