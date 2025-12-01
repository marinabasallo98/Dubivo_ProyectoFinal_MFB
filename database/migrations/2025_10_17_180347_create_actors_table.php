<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Creamos la tabla de actores
    public function up(): void
    {
        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('audio_path')->nullable();
            
            //Selección múltiple (guardamos como JSON)
            $table->json('genders')->nullable(); //Ej: ['Masculino', 'Femenino']
            $table->json('voice_ages')->nullable(); //Ej: ['Niño', 'Adolescente']
            
            //Disponibilidad del actor
            $table->boolean('is_available')->default(true);
            
            //Características de voz
            $table->json('voice_characteristics')->nullable();
            
            $table->timestamps();
        });
    }

    //Eliminamos la tabla de actores
    public function down(): void
    {
        Schema::dropIfExists('actors');
    }
};