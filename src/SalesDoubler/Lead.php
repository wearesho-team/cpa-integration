<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 8:16 AM
 */

namespace Wearesho\Cpa\SalesDoubler;


use Wearesho\Cpa\Interfaces\LeadInterface;

/**
 * Class Lead
 * @package Wearesho\Cpa\SalesDoubler
 */
class Lead implements LeadInterface
{
    protected $clickId;

    public function __construct($clickId)
    {
        $this->clickId = $clickId;
    }

    public function getClickId()
    {
        return $this->clickId;
    }
}