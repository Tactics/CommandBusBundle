<?php

namespace Tactics\CommandBusBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CommandBusCompilerPass
 * @package Tactics\CommandBusBundle\DependencyInjection
 */
class CommandHandlerPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container): void
    {
        if (! $container->hasDefinition('command_bus')) {
            return;
        }

        $definition = $container->getDefinition('command_bus');
        $handlerServices = $container->findTaggedServiceIds('command_handler');

        foreach ($handlerServices as $id => $attributes) {
            $definition->addMethodCall(
                'registerHandler',
                array(new Reference($id))
            );
        }
    }
}