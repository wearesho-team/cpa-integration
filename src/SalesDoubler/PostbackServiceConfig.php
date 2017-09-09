<?php

namespace Wearesho\Cpa\SalesDoubler;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Wearesho\Cpa\Interfaces\PostbackServiceConfigInterface;

/**
 * Class PostbackServiceConfig
 * @package Wearesho\Cpa\SalesDoubler
 */
class PostbackServiceConfig implements PostbackServiceConfigInterface
{
    /** @var  int */
    protected $id;

    /** @var  string */
    protected $token;

    /** @var  string */
    protected $baseUrl;

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
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     * @return self
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
            ->scalarNode("baseUrl")->defaultValue("http://rdr.salesdoubler.com.ua/")->end()
            ->integerNode("id")->isRequired()->end()
            ->scalarNode("token")->isRequired()->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * @return string
     */
    public function getConfigTreeBuilderRoot(): string
    {
        return "SalesDoubler";
    }
}