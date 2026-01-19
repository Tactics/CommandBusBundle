<?php

namespace Tactics\CommandBusBundle\CommandBus;

use Tactics\CommandBusBundle\Command\Command;
use Tactics\CommandBusBundle\CommandHandler\CommandHandler;

/**
 * Interface CommandBus
 * @package Tactics\CommandBusBundle\CommandBus
 */
interface CommandBus
{
    /**
     * @param CommandHandler $handler
     * @return void
     */
    public function registerHandler(CommandHandler $handler): void;

    /**
     * @return array
     */
    public function getHandlers(): array;

    /**
     * @param Command $command
     * @return void
     */
    public function handle(Command $command, $options = []): void;
}
