<?php

namespace Tactics\CommandBusBundle\Tests;

use Tactics\CommandBusBundle\Command\Command;

/**
 * Class TestCommand
 * @package Tactics\CommandBusBundle\Tests
 */
class TestCommand implements Command
{
    /**
     * @var int
     */
    public $counter = 1;
}