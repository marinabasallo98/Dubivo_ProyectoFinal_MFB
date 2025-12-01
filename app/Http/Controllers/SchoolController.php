<?php

namespace App\Http\Controllers;

use App\Models\School;

class SchoolController extends Controller
{
    //Listamos todas las escuelas con sus estadísticas
    public function index()
    {
        $schools = School::withCount('actors')->paginate(12);
        $cities = School::distinct('city')->orderBy('city')->pluck('city');
        
        return view('schools.index', compact('schools', 'cities'));
    }

    //Mostramos una escuela en detalle con sus actores
    public function show(School $school)
    {
        //Cargamos actores y profesores de esta escuela
        $school->load(['actors.user', 'teacherActors.user']);
        $school->loadCount('actors');
        
        return view('schools.show', compact('school'));
    }
}