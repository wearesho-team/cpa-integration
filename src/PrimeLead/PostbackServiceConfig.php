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

/**
 * Class PostbackServiceConfig
 * @package Wearesho\Cpa\PrimeLead
 */
class PostbackServiceConfig implements ConfigurationInterface
{
    /** @var  string */
    protected $baseUri;

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
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * @param string $baseUri
     * @return PostbackServiceConfig
     */
    public function setBaseUri(string $baseUri): self
    {
        $this->baseUri = $baseUri;
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
        $rootNode = $treeBuilder->root("PrimeLead");

        $rootNode->children()
            ->scalarNode("baseUri")->defaultValue("https://primeadv.go2cloud.org/")->end()
            ->integerNode("id")->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}