<?php

use Src\Migrations\Migration;
use Src\Migrations\Schema\Blueprint;
use Src\Migrations\Schema\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('test', function (Blueprint $table) {

            $table->id();

//            $table->string("test", 10)->default("aa");
//            $table->string("name")->unique();
            $table->foreignId("user_id")->references("id")->on("users");

            $table->timestamps();

        });

    }
    public function  down(): void
    {

    }

}->up();