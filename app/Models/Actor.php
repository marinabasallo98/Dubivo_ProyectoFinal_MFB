<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'photo',
        'audio_path',
        'gender',
        'voice_age', 
        'is_available',
        'voice_characteristics'
    ];

    protected $casts = [
        'genders' => 'array',
        'voice_ages' => 'array',
        'is_available' => 'boolean',
        'voice_characteristics' => 'array',
    ];

    public static function getGenderOptions()
{
    return [
        'male' => 'Masculino',
        'female' => 'Femenino', 
        'other' => 'Otro'
    ];
}

    public static function getVoiceAgeOptions()
{
    return [
        'child' => 'Niño',
        'teen' => 'Adolescente', 
        'young_adult' => 'Adulto joven',
        'adult' => 'Adulto',
        'senior' => 'Anciano',
        'variety' => 'Atipada'
    ];
}


   public function scopeFilterByVoiceAges($query, $voiceAges)
{
    if ($voiceAges && count($voiceAges) > 0) {
        $query->where(function ($q) use ($voiceAges) {
            foreach ($voiceAges as $age) {
                $q->orWhereJsonContains('voice_ages', $age);
            }
        });
    }
    return $query;
}

    public function scopeFilterByGenders($query, $genders)
{
    if ($genders && count($genders) > 0) {
        $query->where(function ($q) use ($genders) {
            foreach ($genders as $gender) {
                $q->orWhereJsonContains('genders', $gender);
            }
        });
    }
    return $query;
}

    public function scopeFilterByAvailability($query, $availability)
    {
        if ($availability !== null) {
            return $query->where('is_available', $availability);
        }
        return $query;
    }

    public function scopeFilterBySchools($query, $schoolIds)
    {
        if ($schoolIds && count($schoolIds) > 0) {
            return $query->whereHas('schools', function ($q) use ($schoolIds) {
                $q->whereIn('schools.id', $schoolIds);
            });
        }
        return $query;
    }

    // ACCESORS
    public function getNameAttribute()
    {
        return $this->user->name;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    // HELPERS para mostrar como string
    public function getVoiceAgesStringAttribute()
    {
        return $this->voice_ages ? implode(', ', $this->voice_ages) : '';
    }

    public function getGendersStringAttribute()
    {
        return $this->genders ? implode(', ', $this->genders) : '';
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

public function schools()
{
    return $this->belongsToMany(School::class, 'actor_school');
}

public function works() // o works - revisa cómo lo llamaste en la migración
{
    return $this->belongsToMany(Work::class, 'actor_work')
                ->withPivot('character_name')
                ->withTimestamps();
}

public function requests()
{
    return $this->hasMany(Request::class, 'actor_id');
}

public function teachingSchools()
{
    return $this->belongsToMany(School::class, 'actor_school_teacher')
                ->withPivot('subject', 'teaching_bio', 'is_active_teacher')
                ->withTimestamps();
}

}