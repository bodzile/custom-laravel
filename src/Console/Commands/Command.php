<?php

namespace Src\Console\Commands;

use Src\Console\Interfaces\CommandInterface;

abstract class Command implements CommandInterface
{
    public abstract function handle(string $type, string $name);
}