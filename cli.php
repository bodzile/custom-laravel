<?php

require __DIR__ . '/vendor/autoload.php';

use Src\Console\CommandDispatcher;

$dispatcher = new CommandDispatcher();
$dispatcher->dispatch($argv);