<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/9/17
 * Time: 5:50 PM
 */

namespace Wearesho\Cpa\Tests\Exceptions;


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\Exceptions\UnsupportedConfigException;
use Wearesho\Cpa\Postback\PostbackService;
use Wearesho\Cpa\PrimeLead\PostbackServiceConfig as PrimeLeadPostbackServiceConfig;
use Wearesho\Cpa\Repository\ConversionMemoryRepository;

class UnsupportedConfigExceptionTest extends TestCase
{
    public function testMessageAndGetters()
    {
        $service = new PostbackService(
            new ConversionMemoryRepository(),
            new Client()
        );
        $config = new PrimeLeadPostbackServiceConfig();
        $exception = new UnsupportedConfigException($service, $config);
        $this->assertContains(
            get_class($service),
            $exception->getMessage(),
            "Message should contain service class name"
        );
        $this->assertContains(
            get_class($config),
            $exception->getMessage(),
            "Message should contain config class name"
        );
        $this->assertEquals(
            $service,
            $exception->getService(),
            "Service getter must return service passed as constructor argument"
        );
        $this->assertEquals(
            $config,
            $exception->getConfig(),
            "Config getter must return config instance passed as constructor argument"
        );
    }
}