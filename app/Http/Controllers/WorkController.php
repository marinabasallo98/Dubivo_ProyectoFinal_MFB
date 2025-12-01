<?php

namespace App\Http\Controllers;

use App\Models\Work;

class WorkController extends Controller
{
    //Mostramos todas las obras con sus estadísticas
    public function index()
    {
        $works = Work::withCount('actors')->paginate(12);
        $types = Work::getTypeOptions();
        
        return view('works.index', compact('works', 'types'));
    }

    //Mostramos los detalles de una obra específica
    public function show(Work $work)
    {
        //Cargamos los actores con sus datos completos
        $work->load(['actors.user', 'actors.schools']);
        
        return view('works.show', compact('work'));
    }
}