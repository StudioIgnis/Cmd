[![Build Status](http://img.shields.io/travis/StudioIgnis/cmd.svg?style=flat-square)](https://travis-ci.org/StudioIgnis/cmd)
[![Packagist Version](http://img.shields.io/packagist/v/studioignis/cmd.svg?style=flat-square)](https://packagist.org/packages/studioignis/cmd)
[![Packagist Downloads](http://img.shields.io/packagist/dt/studioignis/cmd.svg?style=flat-square)](https://packagist.org/packages/studioignis/cmd)
![Packagist License](http://img.shields.io/packagist/l/studioignis/cmd.svg?style=flat-square)

StudioIgnis Cmd
===============

Easily implement command based architecture in your project.

_Inspired by laracasts/commander_

Installation
------------

Install through composer by adding the package to your composer.json

```javascript
{
    "require": {
        "studioignis/cmd": "~1.0"
    }
}
```

Or using the command:

```shell
$ composer require studioignis/cmd:~1.0
```

Usage
-----

It is really simple, you just need the command bus instance, then you can start
executing commands! You can bootstrap the instance manually or use included
Laravel service provider.

### Manual bootstrapping

You'll need an implementation of `\StudioIgnis\Cmd\Support\Container` and
`\StudioIgnis\Cmd\NameInflector`.

You'll have to create your own container implementation, since this will depend
on your framework. You can take a look at the included Laravel implementation to
see how it can be implemented, it's extremely simple.

For the name inflector, on the other hand, you can use the one included
`\StudioIgnis\Cmd\DefaultNameInflector`, or you can create your own.

```php
$container = new StudioIgnis\Cmd\CommandBus(
    new Acme\Foo\Container($whatever),
    new StudioIgnis\Cmd\DefaultNameInflector
);
```

### Using Laravel

If you are using the Laravel framework, you can take advantage of the included
service provider. You will need to add it to the `providers` array in your
`app/config/app.php` file:

```php
    'providers' => [
        // ...
        'StudioIgnis\Cmd\Laravel\ServiceProvider',
    ],
```

Now you can just use dependency injection to get the command bus, like so:

```php
use StudioIgnis\Cmd\Bus;

class FooController
{
    public function __construct(Bus $commandBus)
    {
        // ...
    }
}
```

### Handlers

Handlers are as complex as you need them to be, they just need to implement
the `StudioIgnis\Cmd\Handler` interface.

This interface defines only one method, `handle(Command $command)`, that as you
can see, receives the corresponding command instance.

Let's see an (oversimplified) example:

```php
namespace Acme\User\Handler;

use StudioIgnis\Cmd\Command;
use StudioIgnis\Cmd\Handler;
use Acme\User\Command\SignUp as SignUpCommand;

class SignUp implements Handler
{
    public function handle(UserRepository $users)
    {
        $this->users = $users;
    }
    
    public function handle(Command $command)
    {
        /** @var SignUpCommand $command */
        
        $this->users->add($command->name, $command->email, $command->password);
    }
}
```

#### Automatic handler resolving

There's no need to register handlers for commands, as the default name inflector
will take care of it as long as the namespaces are predictable.

The inflector takes the command class name and replaces all occurences of
"Command" with "Handler", so for example `Acme\User\Command\CreateUser` will
result in a handler `Acme\User\Handler\CreateUser`.

You don't have to follow this namespace convention, since all it does is word
replacement, just be aware of what would the handler counterpart of a command
will end up being.

#### Set handlers manually

Another, less magical but sometimes preferred, way is by manually registering
handlers per command:

```php
$bus->setHandler(
    'Acme\User\Command\CreateUser',
    'Acme\User\Command\CreateUserHandler'
);
```

This way you don't have to predict where would a handler end up, you just tell
the bus where to find it.

As you can see in the example above, we are passing the handler's FQN string. By
doing this, the command bus will use the container to resolve the handler, thus,
lazy-loading it. Another way to lazy-load a handler is by passing a closure that
returns a handler instance. Or you can just pass an already instantiated handler.

### Commands

Command classes are simple DTOs, but they must extend from the abstract
`StudioIgnis\Cmd\Command`. This abstract base class ease things up a bit.

Your commands should define an array of attributes that you'll be able to get
automatically, without defining getters.

This base command class also ensures the command can be converted to an array
and serialized to json.

Here's an example:

```php
namespace Acme\User\Command;

use StudioIgnis\cmd\Command;

class SignUp extends Command
{
    public function __construct($name, $email, $password)
    {
        $this->attributes = compact('name', 'email', 'password');
    }
}
```

Now you can access the attributes like this:

```php
// One by one
$name = $signUpCommand->name;
$email = $signUpCommand->email;
$password = $signUpCommand->password;

// As an array
$signUpCommand->toArray();

// As a json string
$json = $signUpCommand->toJson();
$json = (string) $signUpCommand;
$json = json_encode($signUpCommand);
```

#### Executing commands

One you have your command bus instance ready and your handlers registered
(or not!), executing commands is really easy. Let's use the command we defined
above.

```php
$command = new \Acme\User\Command\SignUp(
    'JohnDoe',
    'john.doe@example.com,
    'password!'
);

$bus->execute($command);
```

Traits
------

There are two traits you can use to make command execution a little shorter. One
is generic, the other one is exclusively for Laravel.

### StudioIgnis\Cmd\CmdTrait

This trait adds the `cmd($commandName, array $input)` mehtod. It's purpose is to
initialize a command a little easier by passing the command class name and an
array of inputs that will be used as the command parameters:

```php

$input = [
    'name' => $this->input->get('name'),
    'email' => $this->input->get('email'),
    'password' => $this->input->get('password'),
];

$this->cmd('Acme\User\Command\SignUp', $input);
```

### StudioIgnis\Cmd\Laravel\CmdTrait

This trait uses the previous one so you can just add this trait.  
It adds three new methods: `execute($commandName, array $input = null)`,
`getInput(array $input = null)` and `getCommandBus()`.

The idea is the same, but it also executes the command by calling the other
trait's `cmd()` method.

`getInput(array $input = null)` will return Laravel's `Input::all()` if no
`$input` is given.

`getCommandBus()` will return `App::make('StudioIgnis\Cmd\Bus')`;

Both of these methods can be overriden if you don't want to use the "facade"
invocation.

License
-------

Copyright (c) 2014 Luciano Longo

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
