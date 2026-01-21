<?php

namespace Tactics\CommandBusBundle\CommandBus;

use Tactics\CommandBusBundle\Command\Command;
use Tactics\CommandBusBundle\CommandHandler\CommandHandler;
use Tactics\CommandBusBundle\Exception\DuplicateHandlerException;
use Tactics\CommandBusBundle\Exception\HandlerNotFoundException;
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
    private array $handlers = [];

    /**
     * @var NamingStrategy
     */
    private NamingStrategy $namingStrategy;

    /**e
     * @param NamingStrategy $namingStrategy
     */
    public function __construct(NamingStrategy $namingStrategy)
    {
        $this->namingStrategy = $namingStrategy;
    }

    /**
     * @inheritDoc
     * @throws DuplicateHandlerException
     */
    public function registerHandler(CommandHandler $handler): void
    {
        $this->guardAgainstDuplicateHandlers($handler);
        $this->handlers[$this->namingStrategy->getCommandHandlerName($handler)] = $handler;
    }

    /**
     * @inheritDoc
     */
    public function getHandlers(): array
    {
        return $this->handlers;
    }

    /**
     * @inheritDoc
     * @throws HandlerNotFoundException
     */
    public function handle(Command $command, $options = []): void
    {
        $commandName = $this->namingStrategy->getCommandName($command);
        $handler = $this->findHandler($commandName);

        if (! $handler) {
            throw new HandlerNotFoundException($commandName);
        }

        $handler->handle($command, $options);
    }

    /**
     * @param CommandHandler $handler
     * @throws DuplicateHandlerException
     */
    private function guardAgainstDuplicateHandlers(CommandHandler $handler): void
    {
        if ($this->findHandler($this->namingStrategy->getCommandHandlerName($handler))) {
            throw new DuplicateHandlerException($handler);
        }
    }

    /**
     * @param string $needle
     * @return CommandHandler|null
     */
    private function findHandler(string $needle): ?CommandHandler
    {
        return $this->handlers[$needle] ?? null;
    }
}
