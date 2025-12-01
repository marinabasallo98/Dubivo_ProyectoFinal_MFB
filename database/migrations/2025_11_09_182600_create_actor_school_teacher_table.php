<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Creamos tabla para actores que son profesores
    public function up(): void
    {
        Schema::create('actor_school_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('subject')->nullable(); //Materia que imparte
            $table->text('teaching_bio')->nullable(); //Biografía como profesor
            $table->boolean('is_active_teacher')->default(true);
            $table->timestamps();
        });
    }

    //Eliminamos la tabla de profesores
    public function down(): void
    {
        Schema::dropIfExists('actor_school_teacher');
    }
};