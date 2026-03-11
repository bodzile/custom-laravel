<?php

namespace Src\Migrations\Interfaces;

interface MigrationInterface
{
    public function up();
    public function down();
}