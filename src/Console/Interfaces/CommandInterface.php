<?php

namespace Src\Console\Interfaces;

interface CommandInterface
{
    public function handle(string $type, string $name);
}