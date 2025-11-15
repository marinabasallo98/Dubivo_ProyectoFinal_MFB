<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::withCount('actors')->latest()->paginate(12);
        return view('schools.index', compact('schools'));
    }

    public function show(School $school)
{
    $school->loadCount('actors');
    $school->load(['actors.user', 'teacherActors.user']); 
    return view('schools.show', compact('school'));
}
}