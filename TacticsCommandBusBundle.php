<?php

namespace Tactics\CommandBusBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Tactics\CommandBusBundle\DependencyInjection\CommandHandlerPass;

/**
 * Class TacticsCommandBusBundle
 * @package Tactics\CommandBusBundle
 */
class TacticsCommandBusBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CommandHandlerPass());
    }
}
