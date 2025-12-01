<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Creamos tabla pivote para actores y obras
    public function up(): void
    {
        Schema::create('actor_work', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->constrained()->onDelete('cascade');
            $table->foreignId('work_id')->constrained()->onDelete('cascade');
            $table->string('character_name')->nullable(); //Personaje que interpretó
            $table->timestamps();
        });
    }

    //Eliminamos la tabla pivote
    public function down(): void
    {
        Schema::dropIfExists('actor_work');
    }
};