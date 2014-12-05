<?php

namespace Tactics\CommandBusBundle\Tests;

use Tactics\CommandBusBundle\CommandBus\SimpleCommandBus;
use Tactics\CommandBusBundle\NamingStrategy\ShortNameStrategy;

/**
 * Class SimpleCommandBusTest
 * @package Tactics\CommandBusBundle\Tests
 */
class SimpleCommandBusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @inheritDoc
     */
    public function setUp()
    {
        $this->commandHandler = $this->getMockBuilder('Tactics\CommandBusBundle\CommandHandler\CommandHandler')
            ->setMethods(['handle'])
            ->getMock()
        ;

        $this->simpleCommandBus = new SimpleCommandBus(new ShortNameStrategy());
    }

    /**
     * @test
     * @group command_bus
     */
    public function it_registers_a_handler()
    {
        $this->simpleCommandBus->registerHandler($this->commandHandler);

        $this->assertContains($this->commandHandler, $this->simpleCommandBus->getHandlers());
    }

    /**
     * @test
     * @group command_bus
     * @expectedException \Tactics\CommandBusBundle\Exception\DuplicateHandlerException
     */
    public function it_throws_an_error_on_duplicate_handlers()
    {
        $this->simpleCommandBus->registerHandler($this->commandHandler);
        $this->simpleCommandBus->registerHandler($this->commandHandler);
    }

    /**
     * @test
     * @group command_bus
     */
    public function it_lets_a_handler_handle_a_command()
    {
        $command = new TestCommand();

        $this->simpleCommandBus->registerHandler(new TestCommandHandler());
        $this->simpleCommandBus->handle($command);

        $this->assertEquals(2, $command->counter);
    }
}