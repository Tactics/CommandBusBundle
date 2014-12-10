<?php

namespace Tactics\CommandBusBundle\Tests\Command;

use Symfony\Component\Validator\Validation;
use Tactics\CommandBusBundle\Command\Command;

class CommandTestCase extends \PHPUnit_Framework_TestCase
{
    protected function getValidator()
    {
        return Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
    }

    protected function validateAndCheckIfErrorExists(Command $command, $propertyName)
    {
        return in_array($propertyName, $this->getInvalidPropertyNames($this->getValidator()->validate($command)));
    }

    protected function getInvalidPropertyNames($constraintViolationList)
    {
        $invalidPropertyNames = array();
        foreach ($constraintViolationList as $constraintViolation) {
            $invalidPropertyNames[] = $constraintViolation->getPropertyPath();
        }
        return $invalidPropertyNames;
    }

    public function assertPropertyInvalid(Command $command, $propertyName)
    {
        $this->assertTrue($this->validateAndCheckIfErrorExists($command, $propertyName));
    }

    public function assertPropertyValid(Command $command, $propertyName)
    {
        $this->assertFalse($this->validateAndCheckIfErrorExists($command, $propertyName));
    }
} 