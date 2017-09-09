<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/8/17
 * Time: 6:02 PM
 */

namespace Wearesho\Cpa\Postback;

use Wearesho\Cpa\Interfaces\PostbackServiceInterface;

/**
 * Class PostbackServiceConfigFactory
 * @package Wearesho\Cpa
 */
class PostbackServiceConfigFactory
{
    /** @var  array will be used to fill postback service config properties */
    protected $config;

    public function __construct(array $config)
    {
        $this->config;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function instantiate(PostbackServiceInterface $service)
    {

    }
}