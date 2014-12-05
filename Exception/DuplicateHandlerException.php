<?php

namespace Tactics\CommandBusBundle\Exception;

use Tactics\CommandBusBundle\CommandHandler\CommandHandler;

/**
 * Class UnregisteredHandler
 * @package Tactics\CommandBusBundle\Exception
 */
class DuplicateHandlerException extends \Exception
{
    /**
     * @param CommandHandler $handler
     */
    public function __construct(CommandHandler $handler)
    {
        parent::__construct(sprintf('Handler of class "%s" is already registered.', get_class($handler)));
    }
}