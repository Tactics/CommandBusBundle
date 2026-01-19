<?php

namespace Tactics\CommandBusBundle\NamingStrategy;

use Tactics\CommandBusBundle\Command\Command;
use Tactics\CommandBusBundle\CommandHandler\CommandHandler;

/**
 * Interface NamingStrategy
 * @package Tactics\CommandBusBundle\NamingStrategy
 */
interface NamingStrategy
{
    /**
     * @param Command $command
     * @return string
     */
    public function getCommandName(Command $command): string;

    /**
     * @param CommandHandler $handler
     * @return string
     */
    public function getCommandHandlerName(CommandHandler $handler): string;
}