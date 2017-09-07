<?php

namespace Wearesho\Cpa\SalesDoubler;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class PostbackServiceConfig
 * @package Wearesho\Cpa\SalesDoubler
 */
class PostbackServiceConfig implements ConfigurationInterface
{
    /** @var  int */
    protected $id;

    /** @var  string */
    protected $token;

    /** @var  string */
    protected $baseUri;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PostbackServiceConfig
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return PostbackServiceConfig
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * @param string $baseUri
     * @return self
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
        $rootNode = $treeBuilder->root("SalesDoubler");

        $rootNode->children()
            ->scalarNode("baseUri")->defaultValue("http://rdr.salesdoubler.com.ua/")->end()
            ->integerNode("id")->isRequired()->end()
            ->scalarNode("token")->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}