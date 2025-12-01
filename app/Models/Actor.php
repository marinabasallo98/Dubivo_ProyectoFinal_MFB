<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Actor extends Model
{
    use HasFactory;

    //Campos que podemos llenar masivamente
    protected $fillable = [
        'user_id',
        'bio',
        'photo',
        'audio_path',
        'genders',
        'voice_ages',
        'is_available',
        'voice_characteristics'
    ];

    //Conversiones automáticas
    protected $casts = [
        'genders' => 'array',
        'voice_ages' => 'array',
        'is_available' => 'boolean',
        'voice_characteristics' => 'array',
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

    //Filtramos actores según los parámetros recibidos
    public function scopeFiltrar($query, $request)
    {
        //Por disponibilidad
        if ($request->filled('availability')) {
            $isAvailable = $request->availability === '1' ? true : false;
            $query->filterByAvailability($isAvailable);
        }

        //Por géneros
        if ($request->filled('genders')) {
            $genders = is_array($request->genders) ? $request->genders : [$request->genders];
            $query->filterByGenders($genders);
        }

        //Por edades de voz
        if ($request->filled('voice_ages')) {
            $voiceAges = is_array($request->voice_ages) ? $request->voice_ages : [$request->voice_ages];
            $query->filterByVoiceAges($voiceAges);
        }

        //Por escuelas
        if ($request->filled('schools')) {
            $schoolIds = is_array($request->schools) ? $request->schools : [$request->schools];
            $query->filterBySchools($schoolIds);
        }

        //Por búsqueda de nombre
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        return $query;
    }

    //Agregamos trabajos con sus personajes
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

    //Obtenemos la URL de la foto (o una por defecto)
    public function getFotoUrlAttribute()
    {
        if ($this->photo) {
            return Storage::url($this->photo);
        }
        
        return asset('images/default-actor.jpg');
    }

    //Obtenemos la URL del audio
    public function getAudioUrlAttribute()
    {
        if ($this->audio_path) {
            return Storage::url($this->audio_path);
        }
        
        return null;
    }

    //Accesores (getters)
    public function getNameAttribute()
    {
        return $this->user->name;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    //Convertimos a string para mostrar
    public function getVoiceAgesStringAttribute()
    {
        $voiceAges = $this->voice_ages;
        if (is_string($voiceAges)) {
            $voiceAges = json_decode($voiceAges, true) ?? [];
        }
        $voiceAges = is_array($voiceAges) ? $voiceAges : [];
        return $voiceAges ? implode(', ', $voiceAges) : '';
    }

    public function getGendersStringAttribute()
    {
        $genders = $this->genders;
        if (is_string($genders)) {
            $genders = json_decode($genders, true) ?? [];
        }
        $genders = is_array($genders) ? $genders : [];
        return $genders ? implode(', ', $genders) : '';
    }

    //Obtenemos arrays seguros
    public function getGendersArrayAttribute()
    {
        $genders = $this->genders;
        if (is_string($genders)) {
            $genders = json_decode($genders, true) ?? [];
        }
        return is_array($genders) ? $genders : [];
    }

    public function getVoiceAgesArrayAttribute()
    {
        $voiceAges = $this->voice_ages;
        if (is_string($voiceAges)) {
            $voiceAges = json_decode($voiceAges, true) ?? [];
        }
        return is_array($voiceAges) ? $voiceAges : [];
    }

    //Relaciones
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
            ->withPivot('subject', 'teaching_bio', 'is_active_teacher')
            ->withTimestamps();
    }

    //Verificamos si es profesor
    public function isTeacher()
    {
        return $this->teachingSchools()->where('is_active_teacher', true)->exists();
    }

    //Obtenemos escuelas donde enseña
    public function getActiveTeachingSchools()
    {
        return $this->teachingSchools()->where('is_active_teacher', true)->get();
    }
}