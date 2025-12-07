<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Actor extends Model
{
    use HasFactory;

    //Campos que se pueden llenar masivamente
    protected $fillable = [
        'user_id',
        'bio',
        'photo',
        'audio_path',
        'genders',
        'voice_ages',
        'is_available',
    ];

    //Conversiones automáticas
    protected $casts = [
        'genders' => 'array',
        'voice_ages' => 'array',
        'is_available' => 'boolean',
    ];

    //Opciones para géneros
    public static function getGenderOptions()
    {
        return ['Masculino', 'Femenino', 'Otro'];
    }

    //Opciones para edades de voz
    public static function getVoiceAgeOptions()
    {
        return ['Niño', 'Adolescente', 'Adulto joven', 'Adulto', 'Anciano', 'Atipada'];
    }

    // Agregamos trabajos con sus personajes
    public function agregarTrabajos($workIds, $characterNames = [])
    {
        $worksData = [];
        foreach ($workIds as $workId) {
            $worksData[$workId] = [
                'character_name' => $characterNames[$workId] ?? null
            ];
        }
        $this->works()->sync($worksData);
    }

    // Obtenemos la URL de la foto (o por defecto)
    public function getFotoUrlAttribute()
    {
        return $this->photo ? Storage::url($this->photo) : asset('images/default-actor.jpg');
    }

    // Obtenemos la URL del audio
    public function getAudioUrlAttribute()
    {
        return $this->audio_path ? Storage::url($this->audio_path) : null;
    }

    // Accesores para nombre y email del usuario
    public function getNameAttribute()
    {
        return $this->user->name;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    // Convertimos arrays a strings para mostrar
    public function getVoiceAgesStringAttribute()
    {
        $voiceAges = $this->voice_ages ?? [];
        return is_array($voiceAges) ? implode(', ', $voiceAges) : '';
    }
    public function getGendersStringAttribute()
    {
        $genders = $this->genders ?? [];
        return is_array($genders) ? implode(', ', $genders) : '';
    }

    // Arrays seguros
    public function getGendersArrayAttribute()
    {
        $genders = is_string($this->genders) ? json_decode($this->genders, true) : $this->genders;
        return is_array($genders) ? $genders : [];
    }

    public function getVoiceAgesArrayAttribute()
    {
        $voiceAges = is_string($this->voice_ages) ? json_decode($this->voice_ages, true) : $this->voice_ages;
        return is_array($voiceAges) ? $voiceAges : [];
    }

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'actor_school');
    }

    public function works()
    {
        return $this->belongsToMany(Work::class, 'actor_work')
            ->withPivot('character_name')
            ->withTimestamps();
    }

    public function teachingSchools()
    {
        return $this->belongsToMany(School::class, 'actor_school_teacher')
            ->withPivot('is_active_teacher')
            ->withTimestamps();
    }

    // Verificamos si es profesor
    public function isTeacher()
    {
        return $this->teachingSchools()->where('is_active_teacher', true)->exists();
    }

    // Obtenemos escuelas donde enseña
    public function getActiveTeachingSchools()
    {
        return $this->teachingSchools()->where('is_active_teacher', true)->get();
    }
    /**
     * Verifica si el perfil del actor tiene la información mínima requerida.
     * * @return bool
     */
    public function isComplete(): bool
    {
        // Define las reglas mínimas para que un perfil se considere "completo"
        return !empty($this->photo) &&
            !empty($this->audio_path) &&
            !empty($this->bio) &&
            count($this->genders ?? []) > 0 &&
            count($this->voice_ages ?? []) > 0;
    }
}
