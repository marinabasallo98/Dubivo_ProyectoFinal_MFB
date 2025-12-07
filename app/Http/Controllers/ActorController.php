<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\School;
use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ActorController extends Controller
{
    // Listamos los actores con los filtros aplicados
    public function index(Request $request)
    {
        $actors = Actor::with('user', 'schools');

        // Filtro por disponibilidad
        if ($request->filled('availability')) {
            $actors->where('is_available', $request->availability === '1');
        }

        // Filtro por géneros - AND
        if ($request->filled('genders')) {
            foreach ($request->genders as $gender) {
                $actors->whereJsonContains('genders', $gender);
            }
        }

        // Filtro por edades vocales - AND
        if ($request->filled('voice_ages')) {
            foreach ($request->voice_ages as $age) {
                $actors->whereJsonContains('voice_ages', $age);
            }
        }

        // Filtro por escuelas (many-to-many) - AND
        if ($request->filled('schools')) {
            foreach ($request->schools as $schoolId) { // Por cada ID de escuela seleccionada, añadimos una cláusula whereHas separada.
                $actors->whereHas('schools', function ($q) use ($schoolId) { // Laravel las encadena con AND.
                    $q->where('schools.id', $schoolId);
                });
            }
        }

        // Búsqueda por nombre (user)
        if ($request->filled('search')) {
            $search = $request->search;
            $actors->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Ordenamiento (ej. por fecha de creación)
        $actors = $actors->latest()->paginate(15)->withQueryString();

        // Datos para filtros
        $genders = ['Femenino', 'Masculino', 'Otro'];
        $voiceAges = ['Niño', 'Adolescente', 'Adulto joven', 'Adulto', 'Anciano', 'Atipada'];
        $schools = School::orderBy('name')->get();

        return view('actors.index', compact('actors', 'genders', 'voiceAges', 'schools'));
    }


    public function edit()
    {
        // 1. Nos aseguramos de que el usuario logueado sea un actor y tenga un perfil
        Auth::user()->actorProfile;
        if (!$actor) {
            return redirect()->route('dashboard')->with('error', 'Tu perfil de actor no fue encontrado.');
        }

        // 2. Cargamos los datos necesarios para las pestañas de Formación y Experiencia
        $schools = School::orderBy('name')->get();
        $works = Work::orderBy('title')->get();

        // 3. Devolvemos la vista del ACTOR (simple)
        return view('actors.edit', compact('actor', 'schools', 'works'));
    }

    public function create()
    {
        // Si ya tiene perfil, lo redirigimos a editar.
        if (Auth::user()->actorProfile) {
            return redirect()->route('actor.profile.edit');
        }

        // 1. OBTENER LAS OPCIONES DE GÉNERO Y EDADES DE VOZ
        $genders = Actor::getGenderOptions();
        $voiceAges = Actor::getVoiceAgeOptions();

        // Asegúrate de pasar los datos necesarios para el formulario de creación si es necesario.
        $schools = School::orderBy('name')->get();
        $works = Work::orderBy('title')->get();

        // 2. AÑADIR LAS NUEVAS VARIABLES A LA VISTA
        return view('actors.create', compact('schools', 'works', 'genders', 'voiceAges'));
    }

    public function store(Request $request)
    {
        // 1. Verificación: Si el actor ya tiene un perfil, no puede crearlo de nuevo.
        if (Auth::user()->actorProfile) {
            return redirect()->route('dashboard')->with('error', 'Tu perfil de actor ya existe. Por favor, edítalo.');
        }

        // 2. Validación (Ajusta estas reglas)
        $request->validate([
            'bio' => 'required|string|max:1000',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'audio_path' => 'nullable|file|mimes:mp3,wav|max:5120',
            'genders' => 'required|array',
            'voice_ages' => 'required|array',
            'schools' => 'nullable|array',
            'schools.*' => 'exists:schools,id',
            'works' => 'nullable|array',
            'works.*' => 'exists:works,id',
            'character_names' => 'nullable|array',
        ]);

        // 3. Manejo de archivos
        $photoPath = $request->hasFile('photo') ?
            $this->guardarArchivo($request->file('photo'), 'photos') : null;

        $audioPath = $request->hasFile('audio_path') ?
            $this->guardarArchivo($request->file('audio_path'), 'audios') : null;

        // 4. Creación del modelo Actor
        $actor = Actor::create([
            'user_id' => Auth::id(),
            'bio' => $request->bio,
            'photo' => $photoPath,
            'audio_path' => $audioPath,
            'genders' => $request->genders,
            'voice_ages' => $request->voice_ages,
            'is_available' => $request->boolean('is_available', true),
        ]);

        // 5. Sincronización de relaciones
        $actor->schools()->sync($request->schools);
        //Sincronización de obras destacadas con el nombre del personaje
        if ($request->filled('works')) {
            $syncData = [];
            foreach ($request->works as $workId) {
                // 1. Obtiene el nombre del personaje. Si es nulo o vacío, usa cadena vacía.
                $characterName = $request->input("character_names.$workId") ?? '';

                // 2. Formato especial para guardar datos en la columna pivote 'character_name'.
                $syncData[$workId] = ['character_name' => $characterName];
            }

            // 3. Sincroniza la relación many-to-many.
            $actor->works()->sync($syncData);
        } else {
            // Si no hay obras seleccionadas, elimina cualquier relación.
            $actor->works()->detach();
        }

        return redirect()->route('dashboard')->with('success', '¡Perfil de actor creado con éxito!');
    }


    public function update(Request $request)
    {
        $actor = Auth::user()->actorProfile;
        $request->validate([
            'is_available' => ['required', 'boolean'],
            'genders' => ['nullable', 'array'],
            'voice_ages' => ['nullable', 'array'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'audio_path' => ['nullable', 'file', 'mimes:mp3,wav', 'max:5120'],
            'schools' => ['nullable', 'array'],
            'teaching_schools' => ['nullable', 'array'],
            'works' => ['nullable', 'array'],
        ]);

        // Manejo de archivos
        if ($request->hasFile('photo')) {
            $this->eliminarArchivo($actor->photo);
            $actor->photo = $this->guardarArchivo($request->file('photo'), 'photos');
        }

        if ($request->hasFile('audio_path')) {
            $this->eliminarArchivo($actor->audio_path);
            $actor->audio_path = $this->guardarArchivo($request->file('audio_path'), 'audios');
        }

        // Actualización de datos simples
        $actor->fill($request->only([
            'is_available',
            'bio',
        ]));
        $actor->genders = $request->genders ?? [];
        $actor->voice_ages = $request->voice_ages ?? [];
        $actor->save();


        // Sincronización de relaciones Many-to-Many
        $actor->schools()->sync($request->schools ?? []);
        $actor->teachingSchools()->sync($request->teaching_schools ?? []);
        $actor->works()->sync($request->works ?? []);


        return redirect()->route('dashboard.actor.edit')->with('success', 'Perfil actualizado correctamente.');
    }

    public function deletePhoto()
    {
        $actor = Auth::user()->actorProfile;

        if (!$actor) {
            return redirect()->back()->with('error', 'Perfil no encontrado.');
        }

        if ($actor->photo) {
            $this->eliminarArchivo($actor->photo);
            $actor->photo = null;
            $actor->save();
            return redirect()->back()->with('success', 'Foto de perfil eliminada correctamente.');
        }

        return redirect()->back();
    }

    public function deleteAudio()
    {
        $actor = Auth::user()->actorProfile;
        if (!$actor) {
            return redirect()->back()->with('error', 'Perfil no encontrado.');
        }

        if ($actor->audio_path) {
            $this->eliminarArchivo($actor->audio_path);
            $actor->audio_path = null;
            $actor->save();
            return redirect()->back()->with('success', 'Muestra de voz eliminada correctamente.');
        }

        return redirect()->back();
    }

    public function destroyProfile()
    {
        // Obtenemos el usuario autenticado
        $user = Auth::user();

        // 1. OBTENER EL PERFIL DEL ACTOR CON EL NOMBRE DE RELACIÓN CORRECTO
        $actor = $user->actorProfile;

        if ($actor) {
            // 2. Eliminar archivos asociados (foto y audio)
            // Usamos los métodos privados de tu controlador
            if ($actor->photo) $this->eliminarArchivo($actor->photo);
            if ($actor->audio_path) $this->eliminarArchivo($actor->audio_path);

            // 3. Eliminamos el perfil del actor. 
            $actor->delete();
        }

        // 4. Eliminamos el usuario (esto es lo que borra la cuenta)
        $user->delete();

        // 5. Cerramos sesión y redirigimos
        Auth::logout();

        // Invalidamos la sesión por seguridad
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('success', 'Tu cuenta ha sido eliminada correctamente.');
    }


    // Eliminamos el perfil del actor y su cuenta de usuario
    public function destroy(Actor $actor)
    {
        // Solo el dueño o el admin pueden eliminar
        if (Auth::id() !== $actor->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permiso.');
        }

        // Si es admin eliminando desde su panel, redirigimos a la lista de admin
        if (Auth::user()->role == 'admin') {
            $actor->delete();
            return redirect()->route('admin.actors')->with('success', 'Perfil eliminado.');
        }

        // Si es el actor eliminando su propia cuenta
        $userId = $actor->user_id;
        $actor->delete();
        User::find($userId)->delete();

        Auth::logout();

        return redirect('/')->with('success', 'Tu cuenta ha sido eliminada.');
    }

    // Mostramos detalles
    public function show(Actor $actor)
    {
        $actor->load(['user', 'schools', 'works']);
        return view('actors.show', compact('actor'));
    }

    // Actualizamos disponibilidad vía AJAX
    public function updateAvailability(Request $request, Actor $actor)
    {
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



    // Muestra el formulario de edición del actor logueado
    public function editProfile()
    {
        // Usamos Auth::user() para obtener el perfil del actor logueado
        $actor = Auth::user()->actorProfile;

        if (!$actor) {
            return redirect()->route('dashboard')->with('error', 'Tu perfil de actor no está configurado.');
        }

        // Cargamos los datos necesarios para los selects del formulario
        $schools = School::orderBy('name')->get();
        $works = Work::orderBy('title')->get();

        // Devolvemos la vista edit.blade.php (la que ya tienes)
        return view('actors.edit', compact('actor', 'schools', 'works'));
    }

    // Procesa y guarda los datos de edición del actor logueado
    public function updateProfile(Request $request)
    {
        $actor = Auth::user()->actorProfile;

        if (!$actor) {
            return redirect()->route('dashboard')->with('error', 'Perfil no encontrado.');
        }

        // 1. Validación
        $request->validate([
            'bio' => ['required', 'string', 'max:5000'],
            'genders' => ['nullable', 'array'],
            'voice_ages' => ['nullable', 'array'],
            'photo' => ['nullable', 'image', 'max:2048'], // 2MB
            'audio_path' => ['nullable', 'file', 'mimes:mp3,wav', 'max:5120'], // 5MB
            'schools' => ['nullable', 'array'],
            'works' => ['nullable', 'array'],
            'character_names' => ['nullable', 'array'],
        ]);

        // 2. Procesamiento de datos y archivos
        $data = $request->except(['photo', 'audio_path', 'schools', 'works', 'character_names']);

        if ($request->hasFile('photo')) {
            $this->eliminarArchivo($actor->photo);
            $data['photo'] = $this->guardarArchivo($request->file('photo'), 'photos/actors');
        }

        if ($request->hasFile('audio_path')) {
            $this->eliminarArchivo($actor->audio_path);
            $data['audio_path'] = $this->guardarArchivo($request->file('audio_path'), 'audio/actors');
        }

        // 3. Actualización y sincronización
        $actor->update($data);
        $actor->schools()->sync($request->schools ?? []);

        if ($request->filled('works')) {
            $syncData = [];
            foreach ($request->works as $workId) {
                $characterName = $request->input("character_names.$workId") ?? '';
                $syncData[$workId] = ['character_name' => $characterName];
            }
            $actor->works()->sync($syncData);
        } else {
            $actor->works()->detach();
        }

        return redirect()->route('dashboard')->with('success', 'Tu perfil se ha actualizado correctamente.');
    }

    // ======== MÉTODOS PRIVADOS ========

    private function guardarArchivo($archivo, $carpeta)
    {
        // Nos aseguramos de que la carpeta exista y retorna la ruta relativa
        return $archivo->store($carpeta, 'public');
    }

    private function eliminarArchivo($ruta)
    {
        // Eliminamos el archivo si la ruta existe y el archivo existe en el storage público
        if ($ruta && Storage::disk('public')->exists($ruta)) {
            Storage::disk('public')->delete($ruta);
        }
    }

    public function showActorProfile()
    {
        $actor = Auth::user()->actorProfile;
        if (!$actor) {
            return redirect()->route('dashboard')->with('error', 'Perfil no encontrado.');
        }
        return $this->show($actor);
    }
}
