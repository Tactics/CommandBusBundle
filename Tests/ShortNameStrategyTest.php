<?php

namespace Tactics\CommandBusBundle\Tests;

use Tactics\CommandBusBundle\NamingStrategy\ShortNameStrategy;

/**
 * Class ShortNameStrategyTest
 * @package Tactics\CommandBusBundle\Tests
 */
class ShortNameStrategyTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->namingStrategy = new ShortNameStrategy();
    }

    /**
     * @test
     * @group command_bus
     */
    public function returns_matchable_name_of_given_command()
    {
        $testCommand = new TestCommand();

        $this->assertNotEquals(get_class($testCommand), $this->namingStrategy->getCommandName($testCommand));
    }

    /**
     * @test
     * @group command_bus
     */
    public function returns_matchable_name_of_given_command_handler()
    {
        $testHandler = new TestCommandHandler();

        $this->assertStringEndsNotWith('Handler', $this->namingStrategy->getCommandHandlerName($testHandler));
        $this->assertNotEquals(get_class($testHandler), $this->namingStrategy->getCommandHandlerName($testHandler));
    }
}