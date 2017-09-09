<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 10:20 AM
 */

namespace Wearesho\Cpa\Tests\PostbackServices;


use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\Repository\ConversionMemoryRepository;
use Wearesho\Cpa\Tests\Helpers\HttpTestClient;

/**
 * Class CpaTestCase
 * @package Wearesho\Cpa\Tests
 */
abstract class PostbackServiceTestCase extends TestCase
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