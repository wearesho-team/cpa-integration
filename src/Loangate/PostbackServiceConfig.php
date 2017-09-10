<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 9/10/17
 * Time: 1:32 PM
 */

namespace Wearesho\Cpa\Loangate;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Wearesho\Cpa\Interfaces\PostbackServiceConfigInterface;

class PostbackServiceConfig implements PostbackServiceConfigInterface
{
    /** @var  string */
    protected $baseUrl;

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->getConfigTreeBuilderRoot());

        $rootNode->children()
            ->scalarNode("baseUrl")->defaultValue("http://offers.loangate.affise.com/")->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * @return string
     */
    public function getConfigTreeBuilderRoot(): string
    {
        return "Loangate";
    }
}