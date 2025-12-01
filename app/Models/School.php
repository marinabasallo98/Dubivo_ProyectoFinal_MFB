<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    //Campos que podemos llenar
    protected $fillable = [
        'name',
        'city',
        'description',
        'founded_year',
        'website',
        'logo'
    ];

    //Relación con actores (estudiantes)
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_school')
            ->withTimestamps();
    }

    //Relación con profesores (actores que enseñan aquí)
    public function teachers()
    {
        return $this->belongsToMany(Actor::class, 'actor_school_teacher')
            ->withPivot('subject', 'teaching_bio', 'is_active_teacher')
            ->wherePivot('is_active_teacher', true)
            ->withTimestamps();
    }

    //Relación completa con profesores (para admin)
    public function teacherActors()
    {
        return $this->belongsToMany(Actor::class, 'actor_school_teacher')
            ->withPivot('subject', 'teaching_bio', 'is_active_teacher')
            ->withTimestamps();
    }

    //Contamos profesores fácilmente
    public function getTeachersCountAttribute()
    {
        return $this->teachers()->count();
    }
}