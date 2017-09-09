<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 10:13 AM
 */

namespace Wearesho\Cpa\Exceptions;


use Throwable;

/**
 * Class NotImplementedException
 * @package Wearesho\Cpa\Tests\Helpers
 */
class NotImplementedException extends \Exception
{
    /**
     * NotImplementedException constructor.
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($code = 0, Throwable $previous = null)
    {
        $method = $this->getTrace()[0]['function'];
        parent::__construct("Method {$method} not implemented", $code, $previous);
    }
}