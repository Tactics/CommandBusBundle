<?php

namespace Tactics\CommandBusBundle\CommandBus;

use Tactics\CommandBusBundle\Command\Command;
use Tactics\CommandBusBundle\CommandHandler\CommandHandler;
use Tactics\CommandBusBundle\Exception\DuplicateHandlerException;
use Tactics\CommandBusBundle\NamingStrategy\NamingStrategy;

/**
 * Class SimpleCommandBus
 * @package Tactics\CommandBusBundle\CommandBus
 */
class SimpleCommandBus implements CommandBus
{
    /**
     * @var array
     */
    private $handlers = [];

    /**
     * @var \Tactics\CommandBusBundle\NamingStrategy\NamingStrategy
     */
    private $namingStrategy;

    /**e
     * @param NamingStrategy $namingStrategy
     */
    public function __construct(NamingStrategy $namingStrategy)
    {
        $this->namingStrategy = $namingStrategy;
    }

    /**
     * @inheritDoc
     */
    public function registerHandler(CommandHandler $handler)
    {
        $this->guardAgainstDuplicateHandlers($handler);
        $this->handlers[$this->namingStrategy->getCommandHandlerName($handler)] = $handler;
    }

    /**
     * @inheritDoc
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * @inheritDoc
     */
    public function handle(Command $command, $options = [])
    {
        $handler = $this->findHandler($this->namingStrategy->getCommandName($command));

        if (! $handler) {
            return;
        }

        $handler->handle($command, $options);
    }

    /**
     * @param CommandHandler $handler
     * @throws DuplicateHandlerException
     */
    private function guardAgainstDuplicateHandlers(CommandHandler $handler)
    {
        if ($this->findHandler($this->namingStrategy->getCommandHandlerName($handler))) {
            throw new DuplicateHandlerException($handler);
        }
    }

    /**
     * @param string $needle
     * @return CommandHandler
     */
    private function findHandler($needle)
    {
        return array_key_exists($needle, $this->handlers)
            ? $this->handlers[$needle]
            : null;
    }
}
