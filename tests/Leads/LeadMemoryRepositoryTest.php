<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/10/17
 * Time: 9:57 AM
 */

namespace Wearesho\Cpa\Tests\Leads;


use PHPUnit\Framework\TestCase;
use Wearesho\Cpa\Lead\LeadMemoryRepository;
use Wearesho\Cpa\PrimeLead\Lead;

/**
 * Class LeadMemoryRepositoryTest
 * @package Wearesho\Cpa\Tests\Leads
 */
class LeadMemoryRepositoryTest extends TestCase
{
    /** @var  LeadMemoryRepository */
    protected $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->repository = new LeadMemoryRepository();
    }

    public function testRepository()
    {
        $this->assertNull(
            $this->repository->pull(),
            "It must not contain lead by default"
        );
        $lead = new Lead(1);
        $this->repository->push($lead);
        $this->assertEquals(
            $lead,
            $this->repository->pull(),
            "It must pull pushed lead"
        );
    }
}