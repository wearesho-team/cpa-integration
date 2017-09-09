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
class NotImplementedException extends CpaException
{
    protected $method;

    /**
     * NotImplementedException constructor.
     *
     * @param string $method
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $method = null, $code = 0, Throwable $previous = null)
    {
        $this->method = $method ??  $this->getTrace()[0]['function'];
        parent::__construct("Method {$this->method} not implemented", $code, $previous);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}