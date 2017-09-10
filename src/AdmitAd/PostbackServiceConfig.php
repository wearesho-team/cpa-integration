<?php

namespace Wearesho\Cpa\AdmitAd;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Wearesho\Cpa\Interfaces\PostbackServiceConfigInterface;

class PostbackServiceConfig implements PostbackServiceConfigInterface
{

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
            ->scalarNode("baseUrl")->defaultValue("https://ad.admitad.com/")->end()
            ->scalarNode("key")->isRequired()->end()
            ->scalarNode("campaign")->isRequired()->end()
            ->scalarNode('country')->defaultValue('UA')->end()
            ->scalarNode("currency")->defaultValue("UAH")->end()
            ->scalarNode("action")->defaultValue(1)->end()
            ->scalarNode("tariff")->defaultValue(1)->end()
            ->scalarNode("postback")->defaultValue(1)->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * @return string
     */
    public function getConfigTreeBuilderRoot(): string
    {
        return "admitad";
    }
}