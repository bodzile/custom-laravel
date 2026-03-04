<?php

namespace Src\Migrations;

interface MigrationInterface
{
    public function up();
    public function down();
}