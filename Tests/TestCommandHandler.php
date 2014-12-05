<?php

namespace Tactics\CommandBusBundle\Tests;

use Tactics\CommandBusBundle\CommandHandler\CommandHandler;

/**
 * Class TestCommandHandler
 * @package Tactics\CommandBusBundle\Tests
 */
class TestCommandHandler implements CommandHandler
{
    /**
     * @param TestCommand $command
     */
    public function handle(TestCommand $command)
    {
        $command->counter++;
    }
}