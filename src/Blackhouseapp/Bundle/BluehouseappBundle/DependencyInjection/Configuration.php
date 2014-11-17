<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bluehouseapp');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $this->addClassesSection($rootNode);
        $this->addSettingsSection($rootNode);
        $this->addTemplatesSection($rootNode);
        return $treeBuilder;
    }

    private function addTemplatesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
            ->arrayNode('templates')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('audit')->defaultValue('BlackhouseappBluehouseappBundle:Backend/Admin/Audit')->end()
            ->scalarNode('banedIPs')->defaultValue('BlackhouseappBluehouseappBundle:Backend/Admin/BanedIPs')->end()
            ->scalarNode('node')->defaultValue('BlackhouseappBluehouseappBundle:Backend/Admin/Node')->end()
            ->scalarNode('category')->defaultValue('BlackhouseappBluehouseappBundle:Backend/Admin/Category')->end()
            ->scalarNode('member')->defaultValue('BlackhouseappBluehouseappBundle:Backend/Admin/Member')->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }
    /**
     * Adds `classes` section.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
            ->arrayNode('classes')
            ->addDefaultsIfNotSet()
            ->children()
            ->arrayNode('audit')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('model')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Entity\Audit')->end()
            ->scalarNode('controller')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin\AuditController')->end()
            ->scalarNode('repository')->cannotBeEmpty()->end()
//            ->scalarNode('form')->defaultValue('')->end()
            ->end()
            ->end()
            ->arrayNode('banedIPs')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('model')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Entity\BanedIPs')->end()
            ->scalarNode('controller')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin\BanedIPsController')->end()
            ->scalarNode('repository')->cannotBeEmpty()->end()
            ->scalarNode('form')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Form\BanedIPsType')->end()
            ->end()
            ->end()
            ->arrayNode('category')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('model')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Entity\Category')->end()
            ->scalarNode('controller')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin\CategoryController')->end()
            ->scalarNode('repository')->cannotBeEmpty()->end()
            ->scalarNode('form')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Form\CategoryType')->end()
            ->end()
            ->end()
            ->arrayNode('member')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('model')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Entity\Member')->end()
            ->scalarNode('controller')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin\MemberController')->end()
            ->scalarNode('repository')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Entity\MemberRepository')->end()
            ->scalarNode('form')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Form\MemberType')->end()
            ->end()
            ->end()
            ->arrayNode('node')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('model')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Entity\Node')->end()
            ->scalarNode('controller')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin\NodeController')->end()
            ->scalarNode('repository')->cannotBeEmpty()->end()
            ->scalarNode('form')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Form\NodeType')->end()
            ->end()
            ->end()
            ->arrayNode('post')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('model')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Entity\Post')->end()
            ->scalarNode('controller')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Controller\Frontend\PostController')->end()
            ->scalarNode('repository')->cannotBeEmpty()->end()
            ->scalarNode('form')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Form\PostType')->end()
            ->end()
            ->end()
            ->arrayNode('postComment')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('model')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Entity\PostComment')->end()
//            ->scalarNode('controller')->defaultValue('')->end()
            ->scalarNode('repository')->cannotBeEmpty()->end()
            ->scalarNode('form')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Form\PostCommentType')->end()
            ->end()
            ->end()
            ->arrayNode('userBehavior')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('model')->defaultValue('Blackhouseapp\Bundle\BluehouseappBundle\Entity\BanedIPs')->end()
//            ->scalarNode('controller')->defaultValue('')->end()
//            ->scalarNode('repository')->cannotBeEmpty()->end()
//            ->scalarNode('form')->defaultValue('')->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
        ;
    }



    private function addSettingsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
            ->arrayNode('settings')
            ->addDefaultsIfNotSet()
            ->children()
            ->variableNode('paginate')->defaultNull()->end()
            ->variableNode('limit')->defaultNull()->end()
            ->arrayNode('allowed_paginate')
            ->prototype('integer')->end()
            ->defaultValue(array(10, 20, 30))
            ->end()
            ->integerNode('default_page_size')->defaultValue(10)->end()
            ->booleanNode('sortable')->defaultFalse()->end()
            ->variableNode('sorting')->defaultNull()->end()
            ->booleanNode('filterable')->defaultFalse()->end()
            ->variableNode('criteria')->defaultNull()->end()
            ->end()
            ->end()
            ->end()
        ;
    }

}
