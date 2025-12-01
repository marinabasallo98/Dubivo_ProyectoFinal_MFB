<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Creamos tabla pivote para actores y escuelas
    public function up(): void
    {
        Schema::create('actor_school', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    //Eliminamos la tabla pivote
    public function down(): void
    {
        Schema::dropIfExists('actor_school');
    }
};