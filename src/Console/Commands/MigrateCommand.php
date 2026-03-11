<?php

namespace Src\Console\Commands;

use Src\Migrations\Schema\Schema;
use Src\Migrations\Schema\Blueprint;
use Src\Migrations\Migration;

class MigrateCommand extends Command
{
    public function handle(string $type="", string $name="")
    {
        $migrationDir =  "database/migrations";
        $logFile="database/migrations/logs/migration_logs.json";

        if (!is_dir($migrationDir)) {
            echo "Migration directory not found.\n";
            return;
        }

        $migrationFiles = glob($migrationDir . '/*.php');

        if (!file_exists($logFile)) {
            file_put_contents($logFile, json_encode([]));
        }

        $executed = json_decode(file_get_contents($logFile), true) ?? [];

        foreach ($migrationFiles as $file)
        {

            $migrationName = basename($file);

            // Skip already executed migrations
            if (in_array($migrationName, $executed)) {
                continue;
            }

            $migration = require_once $file;
//            if(file_exists($file))
//                die("postoji");
//
//            die("ne postoji");
            //print_r($file); die();

            //print_r($file); die();


            echo "Running migration: {$migrationName}\n";

            $migration->up();

            $executed[] = $migrationName;
        }

        file_put_contents($logFile, json_encode($executed, JSON_PRETTY_PRINT));

        echo "Migrations completed.\n";

    }

}