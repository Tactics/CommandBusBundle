<?php

namespace Tactics\CommandBusBundle\Test\DependencyInjection;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Tactics\CommandBusBundle\DependencyInjection\CommandHandlerPass;

/**
 * Class CommandHandlerPassTest
 * @package Tactics\CommandBusBundle\Test\DependencyInjection
 */
class CommandHandlerPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group command_bus
     */
    public function returns_null_if_command_bus_service_does_not_exist()
    {
        $container = new ContainerBuilder();

        $this->assertNull($this->process($container));
    }

    /**
     * @test
     * @group command_bus
     */
    public function adds_tagged_services_to_command_bus()
    {
        $container = new ContainerBuilder();

        $container
            ->register('command_bus')
            ->setClass('Tactics\CommandBusBundle\CommandBus\SimpleCommandBus')
            ->setArguments([new Definition('Tactics\CommandBusBundle\NamingStrategy\ShortNameStrategy')])
        ;

        $container
            ->register('test_command_handler')
            ->setClass('Tactics\CommandBusBundle\Tests\TestCommandHandler')
            ->addTag('command_handler')
        ;

        $container
            ->register('not_a_command_handler')
            ->setClass('Tactics\CommandBusBundle\Tests\TestCommand')
        ;

        $this->process($container);

        $commandBus = $container->get('command_bus');

        $this->assertContains($container->get('test_command_handler'), $commandBus->getHandlers());
        $this->assertNotContains($container->get('not_a_command_handler'), $commandBus->getHandlers());
    }

    /**
     * @param ContainerBuilder $container
     */
    private function process(ContainerBuilder $container)
    {
        $commandHandlerBus = new CommandHandlerPass();

        return $commandHandlerBus->process($container);
    }
}