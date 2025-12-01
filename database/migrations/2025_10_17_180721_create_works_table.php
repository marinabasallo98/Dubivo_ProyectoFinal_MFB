<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Creamos la tabla de obras
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['movie', 'series', 'commercial', 'animation', 'videogame', 'documentary', 'other']);
            $table->integer('year')->nullable();
            $table->text('description')->nullable();
            $table->string('poster')->nullable();
            $table->timestamps();
        });
    }

    //Eliminamos la tabla de obras
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};