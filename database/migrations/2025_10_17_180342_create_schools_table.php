<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Creamos la tabla de escuelas
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city')->nullable();
            $table->text('description')->nullable();
            $table->integer('founded_year')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    //Eliminamos la tabla de escuelas
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};