<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 10:20 AM
 */

namespace Wearesho\Cpa\Tests;


use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\ConversionMemoryRepository;
use Wearesho\Cpa\Tests\Helpers\HttpTestClient;

/**
 * Class CpaTestCase
 * @package Wearesho\Cpa\Tests
 */
abstract class CpaTestCase extends TestCase
{
    /** @var  ConversionMemoryRepository */
    protected $repository;

    /** @var  HttpTestClient */
    protected $client;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = new ConversionMemoryRepository();
        $this->client = new HttpTestClient();
    }
}