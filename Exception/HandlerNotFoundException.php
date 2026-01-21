<?php

namespace Tactics\CommandBusBundle\Exception;

class HandlerNotFoundException extends \Exception
{
    /**
     * @param string $commandName
     */
    public function __construct(string $commandName)
    {
        parent::__construct(sprintf('Handler of class "%s" is not found.', $commandName));
    }
}