<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 11:41 AM
 */

namespace Wearesho\Cpa\Tests;


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\ConversionMemoryRepository;
use Wearesho\Cpa\Exceptions\UnsupportedConversionTypeException;
use Wearesho\Cpa\SalesDoubler\Lead;
use Wearesho\Cpa\SalesDoubler\Conversion;
use Wearesho\Cpa\SalesDoubler\PostbackService;
use Wearesho\Cpa\SalesDoubler\PostbackServiceConfig;

class UnsupportedConversionTypeExceptionTest extends TestCase
{
    public function testMessage()
    {
        $lead = new Lead(1);
        $conversion = new Conversion($lead, 1);

        $postbackService = new PostbackService(
            new ConversionMemoryRepository(),
            new PostbackServiceConfig(),
            new Client()
        );

        $exception = new UnsupportedConversionTypeException(
            $postbackService,
            $conversion
        );

        $this->assertEquals($exception->getConversion(), $conversion);
        $this->assertEquals($exception->getPostbackService(), $postbackService);

        $this->assertContains(
            get_class($conversion),
            $exception->getMessage(),
            "Message should contain conversion type"
        );

        $this->assertContains(
            get_class($postbackService),
            $exception->getMessage(),
            "Message should contain service class"
        );
    }
}