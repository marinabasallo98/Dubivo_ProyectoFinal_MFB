<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolTeacherController extends Controller
{
    // Mostrar formulario para agregar profesor
    public function create(School $school)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        // Actores que no son aún profesores en esta escuela
        $availableActors = Actor::whereDoesntHave('teachingSchools', function($query) use ($school) {
            $query->where('school_id', $school->id);
        })->with('user')->get();

        return view('admin.schools.add-teacher', compact('school', 'availableActors'));
    }

    // Guardar nuevo profesor
    public function store(Request $request, School $school)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'actor_id' => 'required|exists:actors,id',
            'subject' => 'required|string|max:255',
            'teaching_bio' => 'nullable|string|max:1000'
        ]);

        // Verificar que no sea ya profesor
        if ($school->teacherActors()->where('actor_id', $validated['actor_id'])->exists()) {
            return redirect()->back()->with('error', 'Este actor ya es profesor en esta escuela.');
        }

        $school->teacherActors()->attach($validated['actor_id'], [
            'subject' => $validated['subject'],
            'teaching_bio' => $validated['teaching_bio']
        ]);

        return redirect()->route('schools.show', $school)
                        ->with('success', 'Profesor agregado exitosamente.');
    }

    // Editar información de profesor
    public function edit(School $school, Actor $actor)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $teacherInfo = $school->teacherActors()->where('actor_id', $actor->id)->first();

        if (!$teacherInfo) {
            abort(404, 'Profesor no encontrado.');
        }

        return view('admin.schools.edit-teacher', compact('school', 'actor', 'teacherInfo'));
    }

    // Actualizar profesor
    public function update(Request $request, School $school, Actor $actor)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'teaching_bio' => 'nullable|string|max:1000',
            'is_active_teacher' => 'sometimes|boolean'
        ]);

        $school->teacherActors()->updateExistingPivot($actor->id, $validated);

        return redirect()->route('schools.show', $school)
                        ->with('success', 'Información de profesor actualizada.');
    }

    // Eliminar profesor
    public function destroy(School $school, Actor $actor)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $school->teacherActors()->detach($actor->id);

        return redirect()->route('schools.show', $school)
                        ->with('success', 'Profesor removido exitosamente.');
    }
    public function manage(Request $request, Actor $actor)
{
    if (Auth::user()->role != 'admin') {
        abort(403, 'No autorizado.');
    }

    $validated = $request->validate([
        'school_id' => 'required|exists:schools,id',
        'subject' => 'required|string|max:255',
        'teaching_bio' => 'nullable|string|max:1000',
        'action' => 'required|in:add,update,remove'
    ]);

    if ($request->action == 'remove') {
        $actor->teachingSchools()->detach($validated['school_id']);
        return back()->with('success', 'Profesor removido exitosamente.');
    }

    // Add or update
    $actor->teachingSchools()->syncWithoutDetaching([
        $validated['school_id'] => [
            'subject' => $validated['subject'],
            'teaching_bio' => $validated['teaching_bio']
        ]
    ]);

    $message = $request->action == 'add' ? 'Profesor agregado exitosamente.' : 'Información actualizada.';
    return back()->with('success', $message);
}
}