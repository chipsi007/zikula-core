<?php

namespace Zikula\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * FrameworkExtension configuration structure.
 *
 * @author Jeremy Mikola <jmikola@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    private $debug;

    /**
     * Constructor
     *
     * @param Boolean $debug Whether to use the debug mode
     */
    public function  __construct($debug)
    {
        $this->debug = (Boolean) $debug;
    }

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        return $treeBuilder;
    }
       
    private function addTranslatorSection(ArrayNodeDefinition $rootNode)
    {
    	$rootNode
    	->children()
    	->arrayNode('translator')
    	->info('translator configuration')
    	->canBeEnabled()
    	->fixXmlConfig('fallback')
    	->children()
    	->arrayNode('fallbacks')
    	->beforeNormalization()->ifString()->then(function ($v) { return array($v); })->end()
    	->prototype('scalar')->end()
    	->defaultValue(array('en'))
    	->end()
    	->booleanNode('logging')->defaultValue($this->debug)->end()
    	->end()
    	->end()
    	->end()
    	;
    }    
}
