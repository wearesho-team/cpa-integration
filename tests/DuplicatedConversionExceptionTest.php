<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 11:03 AM
 */

namespace Wearesho\Cpa\Tests;


use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\Exceptions\DuplicatedConversionException;
use Wearesho\Cpa\PrimeLead\Conversion;
use Wearesho\Cpa\PrimeLead\Lead;

class DuplicatedConversionExceptionTest extends TestCase
{
    /** @var  Conversion */
    protected $conversion;

    protected function setUp()
    {
        parent::setUp();
        $lead = new Lead(1);
        $this->conversion = new Conversion($lead, 2);
    }

    public function testMessage()
    {
        $exception = new DuplicatedConversionException($this->conversion);
        $this->assertContains(
            $this->conversion->getId(),
            $exception->getMessage(),
            "Exception message should contain conversion id"
        );
        $this->assertContains(
            get_class($exception->getConversion()),
            $exception->getMessage(),
            "Exception message should contain conversion type"
        );
    }
}