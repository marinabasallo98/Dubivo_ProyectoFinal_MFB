<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolTeacherController extends Controller
{
    //Mostramos el formulario para agregar profesor
    public function create(School $school)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        //Buscamos actores que no sean profesores aquí
        $availableActors = Actor::whereDoesntHave('teachingSchools', function($query) use ($school) {
            $query->where('school_id', $school->id);
        })->with('user')->get();

        return view('admin.schools.add-teacher', compact('school', 'availableActors'));
    }

    //Guardamos un nuevo profesor
    public function store(Request $request, School $school)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'actor_id' => 'required|exists:actors,id',
            'subject' => 'required|string|max:255',
            'teaching_bio' => 'nullable|string|max:1000'
        ], [
            //Mensajes de validación en español
            'required' => 'El campo :attribute es obligatorio.',
            'exists' => 'El actor seleccionado no existe.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => 'El campo :attribute no puede tener más de :max caracteres.',
        ], [
            //Nombres de campos en español
            'actor_id' => 'actor',
            'subject' => 'materia',
            'teaching_bio' => 'biografía docente',
        ]);

        //Verificamos que no sea ya profesor
        if ($school->teacherActors()->where('actor_id', $validated['actor_id'])->exists()) {
            return redirect()->back()->with('error', 'Este actor ya es profesor aquí.');
        }

        $school->teacherActors()->attach($validated['actor_id'], [
            'subject' => $validated['subject'],
            'teaching_bio' => $validated['teaching_bio']
        ]);

        return redirect()->route('schools.show', $school)
                        ->with('success', 'Profesor agregado.');
    }

    //Mostramos formulario para editar profesor
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

    //Actualizamos la información del profesor
    public function update(Request $request, School $school, Actor $actor)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'teaching_bio' => 'nullable|string|max:1000',
            'is_active_teacher' => 'sometimes|boolean'
        ], [
            //Mensajes de validación en español
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => 'El campo :attribute no puede tener más de :max caracteres.',
            'boolean' => 'El campo :attribute debe ser sí o no.',
        ], [
            //Nombres de campos en español
            'subject' => 'materia',
            'teaching_bio' => 'biografía docente',
            'is_active_teacher' => 'profesor activo',
        ]);

        $school->teacherActors()->updateExistingPivot($actor->id, $validated);

        return redirect()->route('schools.show', $school)
                        ->with('success', 'Información actualizada.');
    }

    //Eliminamos un profesor
    public function destroy(School $school, Actor $actor)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $school->teacherActors()->detach($actor->id);

        return redirect()->route('schools.show', $school)
                        ->with('success', 'Profesor removido.');
    }

    //Manejamos profesores desde el panel de admin
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
        ], [
            //Mensajes de validación en español
            'required' => 'El campo :attribute es obligatorio.',
            'exists' => 'La escuela seleccionada no existe.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => 'El campo :attribute no puede tener más de :max caracteres.',
            'in' => 'La acción seleccionada no es válida.',
        ], [
            //Nombres de campos en español
            'school_id' => 'escuela',
            'subject' => 'materia',
            'teaching_bio' => 'biografía docente',
            'action' => 'acción',
        ]);

        if ($request->action == 'remove') {
            $actor->teachingSchools()->detach($validated['school_id']);
            return back()->with('success', 'Profesor removido.');
        }

        //Agregamos o actualizamos
        $actor->teachingSchools()->syncWithoutDetaching([
            $validated['school_id'] => [
                'subject' => $validated['subject'],
                'teaching_bio' => $validated['teaching_bio']
            ]
        ]);

        $message = $request->action == 'add' ? 'Profesor agregado.' : 'Información actualizada.';
        return back()->with('success', $message);
    }
}