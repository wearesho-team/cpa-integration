<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 7:42 AM
 */

namespace Wearesho\Cpa\Interfaces;

/**
 * Interface LeadInterface
 * @package Wearesho\Cpa\Interfaces
 *
 * Lead will be created and stored in cookies or other storage
 * and will be used to create conversion.
 *
 * Lead contains common information, that will be sent to CPA network (Visitor ID etc.)
 */
interface LeadInterface
{
    /**
     * @param string $conversionId
     * @return ConversionInterface
     */
    public function createConversion(string $conversionId): ConversionInterface;
}