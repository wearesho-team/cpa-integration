<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/9/17
 * Time: 2:40 PM
 */

namespace Wearesho\Cpa\Tests\Exceptions;


use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\Exceptions\NotImplementedException;

class NotImplementedMethodExceptionTest extends TestCase
{
    /** @var  NotImplementedException */
    protected $exception;

    protected function setUp()
    {
        parent::setUp();
        $this->exception = new NotImplementedException();
    }

    public function testMessage()
    {
        $this->assertContains(
            "setUp",
            $this->exception->getMethod(),
            "Message should contain method name from trace if not method provided to constructor"
        );
        $this->exception = new NotImplementedException($otherMethodName = "methodName");
        $this->assertContains(
            $otherMethodName,
            $this->exception->getMethod(),
            "Message should contain method name from constructor argument"
        );
    }
}