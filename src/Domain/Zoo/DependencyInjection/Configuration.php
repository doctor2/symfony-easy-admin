<?php

namespace App\Domain\Zoo\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('zoo');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('cages')->defaultValue(1)->end()
        ;

        $this->addAnimalsSection($rootNode);

        return $treeBuilder;
    }

    private function addAnimalsSection(ArrayNodeDefinition $rootNode): void
    {
        $animalsNode = $rootNode
            ->children()
                ->arrayNode('animals')
        ;

        $this->addSpecificAnimalSection('liens', $animalsNode);
        $this->addSpecificAnimalSection('crocodiles', $animalsNode);
        $this->addSpecificAnimalSection('elephants', $animalsNode);
    }

    private function addSpecificAnimalSection(string $animalType, ArrayNodeDefinition $animalsNode): void
    {
        $animalsNode->children()
            ->arrayNode($animalType)
                ->children()
                    ->scalarNode('quantity')->defaultValue(0)->end()
                    ->scalarNode('quantity_in_cage')->defaultValue(0)->end()
        ;
    }
}
