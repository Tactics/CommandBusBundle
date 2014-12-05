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
     */
    public function registerHandler(CommandHandler $handler);

    /**
     * @return array
     */
    public function getHandlers();

    /**
     * @param Command $command
     */
    public function handle(Command $command);
}