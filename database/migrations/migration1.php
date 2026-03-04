<?php

use Src\Migrations\Blueprint;
use Src\Migrations\Migration;
use Src\Migrations\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('test', function (Blueprint $table) {

            $table->integer("id")->primary()->autoIncrement();
            $table->string("test", 10)->default("aa");
            $table->datetime("created_at")->nullable();

        });

    }
    public function  down(): void
    {

    }

}->up();