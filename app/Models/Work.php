<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'year',
        'description',
        'poster'
    ];

    // RELACIONES
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_work')
                    ->withPivot('character_name')
                    ->withTimestamps();
    }

    // SCOPES
    public function scopeMovies($query)
    {
        return $query->where('type', 'movie');
    }

    public function scopeSeries($query)
    {
        return $query->where('type', 'series');
    }

    public function scopeAnimation($query)
    {
        return $query->where('type', 'animation');
    }
    public function scopeCommercial($query)
    {
        return $query->where('type', 'commercial');
    }
    public function scopeVideogame($query)
    {
        return $query->where('type', 'videogame');
    }
    public function scopeDocumentary($query)
    {
        return $query->where('type', 'documentary');
    }
    public function scopeOther($query)
    {
        return $query->where('type', 'other');
    }
}