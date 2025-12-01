<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\School;
use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ActorController extends Controller
{
    //Listamos los actores con los filtros aplicados
    public function index(Request $request)
    {
        $actors = Actor::filtrar($request)
            ->with(['user', 'schools', 'works'])
            ->paginate(12);

        $schools = School::all();
        $genders = Actor::getGenderOptions();
        $voiceAges = Actor::getVoiceAgeOptions();

        return view('actors.index', compact('actors', 'schools', 'genders', 'voiceAges'));
    }

    //Mostramos el formulario para crear un perfil de actor
    public function create()
    {
        //Solo los actores pueden crear perfiles
        if (Auth::user()->role !== 'actor') {
            abort(403, 'Solo actores pueden crear perfiles.');
        }

        //Si ya tiene perfil, lo redirigimos
        if (Auth::user()->actorProfile) {
            return redirect()->route('actors.show', Auth::user()->actorProfile)
                ->with('info', 'Ya tienes un perfil.');
        }

        $data = [
            'schools' => School::all(),
            'works' => Work::all(),
            'genders' => Actor::getGenderOptions(),
            'voiceAges' => Actor::getVoiceAgeOptions()
        ];

        return view('actors.create', $data);
    }

    //Guardamos un nuevo actor en la base de datos
    public function store(Request $request)
    {
        //Validamos los datos recibidos
        $data = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
            'audio' => 'nullable|file|mimes:mp3,wav|max:5120',
            'genders' => 'required|array',
            'voice_ages' => 'required|array',
            'is_available' => 'sometimes|boolean',
            'schools' => 'nullable|array',
            'works' => 'nullable|array'
        ], [
            //Mensajes de error en español
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => [
                'string' => 'El campo :attribute no puede tener más de :max caracteres.',
                'file' => 'El archivo :attribute no puede pesar más de :max KB.',
            ],
            'image' => 'El campo :attribute debe ser una imagen.',
            'file' => 'El campo :attribute debe ser un archivo.',
            'mimes' => 'El campo :attribute debe ser MP3 o WAV.',
            'array' => 'El campo :attribute debe ser una lista.',
            'boolean' => 'El campo :attribute debe ser sí o no.',
        ], [
            //Nombres de campos en español
            'bio' => 'biografía',
            'photo' => 'foto',
            'audio' => 'audio',
            'genders' => 'géneros',
            'voice_ages' => 'edades de voz',
            'is_available' => 'disponibilidad',
            'schools' => 'escuelas',
            'works' => 'trabajos',
        ]);

        //Creamos el actor
        $actor = new Actor();
        $actor->user_id = Auth::id();
        $actor->bio = $data['bio'] ?? null;
        $actor->genders = $data['genders'];
        $actor->voice_ages = $data['voice_ages'];
        $actor->is_available = $request->has('is_available');

        //Guardamos los archivos si se subieron
        if ($request->hasFile('photo')) {
            $actor->photo = $this->guardarArchivo($request->file('photo'), 'actors/photos');
        }

        if ($request->hasFile('audio')) {
            $actor->audio_path = $this->guardarArchivo($request->file('audio'), 'actors/audios');
        }

        $actor->save();

        //Asociamos escuelas y trabajos
        if ($request->has('schools')) {
            $actor->schools()->sync($request->schools);
        }

        if ($request->has('works')) {
            $actor->agregarTrabajos($request->works, $request->character_names ?? []);
        }

        return redirect()->route('actors.show', $actor)
            ->with('success', 'Perfil creado.');
    }

    //Mostramos el formulario para editar un actor
    public function edit(Actor $actor)
    {
        //Verificamos que el usuario tenga permiso
        if (Auth::id() != $actor->user_id && Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $data = [
            'actor' => $actor,
            'schools' => School::all(),
            'works' => Work::all(),
            'genders' => Actor::getGenderOptions(),
            'voiceAges' => Actor::getVoiceAgeOptions()
        ];

        return view('actors.edit', $data);
    }

    //Actualizamos la información de un actor
    public function update(Request $request, Actor $actor)
    {
        //Verificamos permisos
        if (Auth::id() != $actor->user_id && Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        //Validamos los datos
        $data = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
            'audio' => 'nullable|file|mimes:mp3,wav|max:5120',
            'genders' => 'required|array',
            'voice_ages' => 'required|array',
            'is_available' => 'sometimes|boolean',
            'schools' => 'nullable|array',
            'works' => 'nullable|array'
        ], [
            //Mensajes de error en español
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => [
                'string' => 'El campo :attribute no puede tener más de :max caracteres.',
                'file' => 'El archivo :attribute no puede pesar más de :max KB.',
            ],
            'image' => 'El campo :attribute debe ser una imagen.',
            'file' => 'El campo :attribute debe ser un archivo.',
            'mimes' => 'El campo :attribute debe ser MP3 o WAV.',
            'array' => 'El campo :attribute debe ser una lista.',
            'boolean' => 'El campo :attribute debe ser sí o no.',
        ], [
            //Nombres de campos en español
            'bio' => 'biografía',
            'photo' => 'foto',
            'audio' => 'audio',
            'genders' => 'géneros',
            'voice_ages' => 'edades de voz',
            'is_available' => 'disponibilidad',
            'schools' => 'escuelas',
            'works' => 'trabajos',
        ]);

        //Manejamos los archivos subidos
        if ($request->hasFile('photo')) {
            $this->eliminarArchivo($actor->photo);
            $actor->photo = $this->guardarArchivo($request->file('photo'), 'actors/photos');
        }

        if ($request->hasFile('audio')) {
            $this->eliminarArchivo($actor->audio_path);
            $actor->audio_path = $this->guardarArchivo($request->file('audio'), 'actors/audios');
        }

        //Actualizamos los datos del actor
        $actor->update([
            'bio' => $data['bio'] ?? null,
            'genders' => $data['genders'],
            'voice_ages' => $data['voice_ages'],
            'is_available' => $request->has('is_available')
        ]);

        //Sincronizamos las relaciones
        $actor->schools()->sync($request->schools ?? []);

        if ($request->has('works')) {
            $actor->agregarTrabajos($request->works, $request->character_names ?? []);
        } else {
            $actor->works()->detach();
        }

        return redirect()->route('actors.show', $actor)
            ->with('success', 'Perfil actualizado.');
    }

    //Eliminamos un actor
    public function destroy(Actor $actor)
    {
        //Verificamos permisos
        if (Auth::id() != $actor->user_id && Auth::user()->role != 'admin') {
            abort(403, 'No tienes permiso.');
        }

        //Si es admin, solo borramos el perfil
        if (Auth::user()->role == 'admin') {
            $actor->delete();
            return redirect()->route('admin.actors')->with('success', 'Perfil eliminado.');
        }

        //Si el actor borra su cuenta, borramos todo
        $userId = $actor->user_id;
        $actor->delete();
        User::find($userId)->delete();

        Auth::logout();

        return redirect('/')->with('success', 'Tu cuenta ha sido eliminada.');
    }

    //Mostramos los detalles de un actor
    public function show(Actor $actor)
    {
        $actor->load(['user', 'schools', 'works']);
        return view('actors.show', compact('actor'));
    }

    //Actualizamos la disponibilidad de un actor (para AJAX)
    public function updateAvailability(Request $request, Actor $actor)
    {
        //Verificamos permisos
        if (Auth::id() !== $actor->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $actor->update([
            'is_available' => $request->is_available
        ]);

        return response()->json([
            'success' => true,
            'is_available' => $actor->is_available
        ]);
    }

    // ========== MÉTODOS PRIVADOS ==========

    //Guardamos un archivo en el storage
    private function guardarArchivo($archivo, $carpeta)
    {
        return $archivo->store($carpeta, 'public');
    }

    //Eliminamos un archivo si existe
    private function eliminarArchivo($ruta)
    {
        if ($ruta && Storage::disk('public')->exists($ruta)) {
            Storage::disk('public')->delete($ruta);
        }
    }
}