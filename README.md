# SimpleCommandBus

[![Build Status](https://travis-ci.org/Tactics/CommandBusBundle.svg?branch=master)](https://travis-ci.org/Tactics/CommandBusBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Tactics/CommandBusBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Tactics/CommandBusBundle/?branch=master)

Say we have a command called RegisterUser.

```php
<?php

use Pringles\DomainBundle\CommandBus\Command;

class RegisterUser implements Command
{
    public $firstname;
    public $lastname;
}
```

And we want to handle that command.

```php
<?php

use Pringles\DomainBundle\CommandBus\CommandHandler;

class RegisterUserHandler implements CommandHandler
{
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function handle(RegisterUser $registerUser)
    {
        $person = Person::register($registerUser->firstname, $registerUser->lastname);
    }
}
```

We can setup the SimpleCommandBus, register the handler and handle the command.

```php
<?php

use Pringles\DomainBundle\CommandBus\SimpleCommandBus;

function someController()
{
    $bus = new SimpleCommandBus(new ShortNameStrategy());
    $bus->registerHandler(new RegisterUserHandler($personRepository));

    $cmd = new RegisterUser;
    $cmd->firstname = 'Aaron';
    $cmd->lastname = 'Muylaert';

    $bus->handle($cmd);
}
```

SimpleCommandBus finds handlers based on their name. A command named Test requires a
registered handler called TestHandler. If no handler is found, nothing happens.

Oh, one small rule, command handlers are not allowed to return values.

There is a command bus service called ```command_bus```.
You can register a handler by registering your handler as a service and tagging the service as ```command_handler```. Using it looks like this:

```php
<?php

$cmd = new Test;
$cmd->value = 'Foo';

$this->get('command_bus')->handle($cmd);
```

\m/
