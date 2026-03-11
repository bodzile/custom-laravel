<?php

namespace Src\Console\Commands;

use Src\Migrations\Migration;
use Src\Migrations\Schema\Schema;
use Src\Migrations\Schema\Blueprint;

class RollbackCommand extends Command
{

    public function handle(string $type="", string $name="")
    {
        $migrationDir = 'database/migrations';
        $logFile = 'database/migrations/logs/migration_logs.json';

        if (!file_exists($logFile)) {
            echo "No migration log found.\n";
            return;
        }

        $executed = json_decode(file_get_contents($logFile), true);

        if (empty($executed)) {
            echo "No migrations to rollback.\n";
            return;
        }

        // Get last executed migration
        $lastMigration = array_pop($executed);

        $filePath = $migrationDir . '/' . $lastMigration;

        if (!file_exists($filePath)) {
            echo "Migration file not found: {$lastMigration}\n";
            return;
        }

        $migration = require $filePath;

        if (!is_object($migration) || !method_exists($migration, 'down')) {
            echo "Invalid migration: {$lastMigration}\n";
            return;
        }

        echo "Rolling back: {$lastMigration}\n";

        $migration->down();

        // Save updated log
        file_put_contents($logFile, json_encode($executed, JSON_PRETTY_PRINT));

        echo "Rollback completed.\n";
    }

}