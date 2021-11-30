<?php

namespace Marlinc\PassbookBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('marlinc_passbook');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->arrayNode('marlinc_passbook_ios')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('pass_type_identifier')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('team_identifier')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('organization_name')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('p12_certificate')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('p12_certificate_password')->isRequired()->end()
                    ->scalarNode('wwdr_certificate')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('output_path')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('icon_file')->isRequired()->cannotBeEmpty()->end()
                ->end()
            ->end()
            ->arrayNode('marlinc_passbook_google')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('service_account_email_address')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('service_account_file')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('application_name')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('issuser_id')->isRequired()->cannotBeEmpty()->end()
                    ->arrayNode('origins')->scalarPrototype()->end()->end()
                    ->arrayNode('scopes')->scalarPrototype()->end()->end()
                    ->scalarNode('save_link')->isRequired()->cannotBeEmpty()->end()
            ->end()
            ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
