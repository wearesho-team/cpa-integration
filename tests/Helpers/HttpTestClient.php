<?php

namespace Wearesho\Cpa\Tests\Helpers;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Wearesho\Cpa\Exceptions\NotImplementedException;

/**
 * Class HttpTestClient
 * @package Wearesho\Cpa\Tests\Helpers
 */
class HttpTestClient implements ClientInterface
{

    /**
     * @var \Closure
     */
    protected $closure;

    /**
     * Send an HTTP request.
     *
     * @param RequestInterface $request Request to send
     * @param array $options Request options to apply to the given
     *                                  request and to the transfer.
     *
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws NotImplementedException
     */
    public function send(RequestInterface $request, array $options = [])
    {
        if ($this->closure instanceof \Closure) {
            return call_user_func($this->closure, $request, $options);
        }
        throw new NotImplementedException();
    }

    /**
     * @return \Closure
     */
    public function getClosure(): \Closure
    {
        return $this->closure;
    }

    /**
     * @param \Closure $closure
     */
    public function setClosure(\Closure $closure)
    {
        $this->closure = $closure;
    }

    public function sendAsync(RequestInterface $request, array $options = [])
    {
        throw new NotImplementedException();
    }

    public function request($method, $uri, array $options = [])
    {
        throw new NotImplementedException();
    }

    public function requestAsync($method, $uri, array $options = [])
    {
        throw new NotImplementedException();
    }

    public function getConfig($option = null)
    {
        throw new NotImplementedException();
    }

}