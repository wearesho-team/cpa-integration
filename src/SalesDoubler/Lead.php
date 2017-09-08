<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 8:16 AM
 */

namespace Wearesho\Cpa\SalesDoubler;


use Wearesho\Cpa\Interfaces\ConversionInterface;
use Wearesho\Cpa\Interfaces\LeadInterface;

/**
 * Class Lead
 * @package Wearesho\Cpa\SalesDoubler
 */
class Lead implements LeadInterface
{
    /** @var  string */
    protected $clickId;

    /**
     * Lead constructor.
     * @param $clickId
     */
    public function __construct(string $clickId)
    {
        $this->clickId = $clickId;
    }

    /**
     * @return mixed
     */
    public function getClickId(): string
    {
        return $this->clickId;
    }

    /**
     * @param string $conversionId
     * @return ConversionInterface
     */
    public function createConversion(string $conversionId): ConversionInterface
    {
        return new Conversion($this, $conversionId);
    }
}