<?php

namespace Tactics\CommandBusBundle\NamingStrategy;
use Tactics\CommandBusBundle\Command\Command;
use Tactics\CommandBusBundle\CommandHandler\CommandHandler;

/**
 * Class ShortNameStrategy
 * @package Tactics\CommandBusBundle\NamingStrategy
 */
class ShortNameStrategy implements NamingStrategy
{
    /**
     * @inheritDoc
     */
    public function getCommandName(Command $command)
    {
        return (new \ReflectionClass($command))->getShortName();
    }

    /**
     * @inheritDoc
     */
    public function getCommandHandlerName(CommandHandler $commandHandler)
    {
        return str_replace('Handler', '', (new \ReflectionClass($commandHandler))->getShortName());
    }
}