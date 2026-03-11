<?php

namespace Src\Console;

use Src\Console\Commands\MakeCommand;
use Src\Console\Commands\MigrateCommand;
use Src\Console\Commands\RollbackCommand;

class CommandDispatcher
{
    protected array $commands = [
        'make:' => MakeCommand::class,
        'migrate' => MigrateCommand::class,
        'rollback' => RollbackCommand::class,
    ];

    public function dispatch(array $argv): void
    {
        array_shift($argv);

        if (!isset($argv[0]))
        {
            echo "No command provided.\n";
            return;
        }

        $commandInput = array_shift($argv);

        foreach ($this->commands as $command => $class) {

            if ($command === 'make:' && str_starts_with($commandInput, 'make:'))
            {

                $type = substr($commandInput, 5); // remove "make:"
                $name= array_shift($argv);

                $commandInstance = new $class();
                $commandInstance->handle($type, $name);

                return;
            }

            if ($command === $commandInput)
            {
                $commandInstance = new $class();
                $commandInstance->handle();

                return;
            }
        }

        echo "Command '{$commandInput}' not found.\n";
    }
}