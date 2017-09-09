<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/9/17
 * Time: 2:43 PM
 */

namespace Wearesho\Cpa\Tests\Exceptions;


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\Exceptions\UnsupportedPostbackServiceException;
use Wearesho\Cpa\Postback\PostbackService;
use Wearesho\Cpa\Repository\ConversionMemoryRepository;

class UnsupportedPostbackServiceExceptionTest extends TestCase
{
    public function testMessageAndGetter()
    {
        $exception = new UnsupportedPostbackServiceException(
            $service = new PostbackService(
                new ConversionMemoryRepository(),
                new Client()
            )
        );
        $this->assertContains(
            get_class($service),
            $exception->getMessage(),
            "Message should contain class name of passed to constructor service instance"
        );
        $this->assertEquals(
            $service,
            $exception->getService(),
            "Service getter must return service instance passed to constructor"
        );
    }
}