<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/7/17
 * Time: 8:59 AM
 */

namespace Wearesho\Cpa\PrimeLead;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Wearesho\Cpa\Interfaces\PostbackServiceConfigInterface;

/**
 * Class PostbackServiceConfig
 * @package Wearesho\Cpa\PrimeLead
 */
class PostbackServiceConfig implements PostbackServiceConfigInterface
{
    /** @var  string */
    protected $baseUrl;

    /** @var  mixed */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     * @return PostbackServiceConfig
     */
    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->getConfigTreeBuilderRoot());

        $rootNode->children()
            ->scalarNode("baseUrl")->defaultValue("https://primeadv.go2cloud.org/")->end()
            ->integerNode("id")->isRequired()->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * @return string
     */
    public function getConfigTreeBuilderRoot(): string
    {
        return "PrimeLead";
    }
}