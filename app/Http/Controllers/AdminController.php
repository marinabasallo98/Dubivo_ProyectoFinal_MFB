<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Work;
use App\Models\User;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // ========== DASHBOARD ==========

    //Mostramos el panel principal del administrador
    public function dashboard()
    {
        $this->verificarAdmin();

        $stats = [
            'total_users' => User::count(),
            'total_actors' => User::where('role', 'actor')->count(),
            'total_clients' => User::where('role', 'client')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_schools' => School::count(),
            'total_works' => Work::count(),
            'total_teacher_actors' => Actor::has('teachingSchools')->count(), // ← AÑADE ESTO
        ];

        $recentActors = Actor::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentActors'));
    }

    // ===================================
    // ========== ESCUELAS CRUD ==========
    // ===================================

    //Listamos todas las escuelas con filtros (Método ya existente)
    public function schools(Request $request)
    {
        $this->verificarAdmin();

        // Contamos actores (alumnos) y teachers (profesores activos)
        $query = School::withCount(['actors', 'teachers']);

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $schools = $query->latest()->paginate(15);
        $cities = School::select('city')->distinct()->orderBy('city')->pluck('city');

        return view('admin.schools.index', compact('schools', 'cities'));
    }

    // Muestra el formulario de creación de escuela
    public function createSchool()
    {
        $this->verificarAdmin();
        return view('admin.schools.create');
    }

    // Guarda una nueva escuela
    public function storeSchool(Request $request)
    {
        $this->verificarAdmin();

        $request->validate([
            'name' => 'required|string|max:255|unique:schools,name',
            'city' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:1024', // 1MB
        ]);

        $school = School::create($request->only([
            'name',
            'city',
            'description',
            'founded_year',
            'website'
        ]));

        if ($request->hasFile('logo')) {
            $school->logo = $this->guardarArchivo($request->file('logo'), 'schools/logos');
            $school->save();
        }

        return redirect()->route('admin.schools')->with('success', 'Escuela creada correctamente.');
    }

    // Muestra el formulario de edición de escuela
    public function editSchool(School $school)
    {
        $this->verificarAdmin();
        return view('admin.schools.edit', compact('school'));
    }

    // Actualiza los datos de la escuela
    public function updateSchool(Request $request, School $school)
    {
        $this->verificarAdmin();

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('schools')->ignore($school->id)],
            'city' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:1024',
        ]);

        $school->update($request->only([
            'name',
            'city',
            'description',
            'founded_year',
            'website'
        ]));

        if ($request->hasFile('logo')) {
            $this->eliminarArchivo($school->logo);
            $school->logo = $this->guardarArchivo($request->file('logo'), 'schools/logos');
            $school->save();
        }

        return redirect()->route('admin.schools')->with('success', 'Escuela actualizada correctamente.');
    }

    // Elimina el logo de la escuela
    public function deleteSchoolLogo(School $school)
    {
        $this->verificarAdmin();
        $this->eliminarArchivo($school->logo);
        $school->logo = null;
        $school->save();
        return back()->with('success', 'Logo de la escuela eliminado.');
    }

    // Elimina la escuela
    public function destroySchool(School $school)
    {
        $this->verificarAdmin();

        // 1. Eliminar archivos (logo)
        $this->eliminarArchivo($school->logo);

        // 2. Desasociar relaciones (actor_school y actor_school_teacher)
        $school->actors()->detach();
        $school->teacherActors()->detach();

        // 3. Eliminar la escuela
        $school->delete();

        return redirect()->route('admin.schools')->with('success', 'Escuela eliminada correctamente.');
    }

    // ========== ACTORES ==========

    // Listamos todos los actores con filtros
    public function actors(Request $request)
    {
        $this->verificarAdmin();

        $query = Actor::with('user');

        if ($request->filled('availability')) {
            $isAvailable = $request->availability === 'available';
            $query->where('is_available', $isAvailable);
        }

        // 2. Búsqueda por nombre/email
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        //3. Filtro por Género
        if ($request->filled('gender')) {
            $query->whereJsonContains('genders', $request->gender);
        }

        //4. Filtro por Edad Vocal
        if ($request->filled('voice_age')) {
            $query->whereJsonContains('voice_ages', $request->voice_age);
        }

        $genders = ['Masculino', 'Femenino', 'Otro'];
        $voiceAges = ['Niño', 'Adolescente', 'Adulto joven', 'Adulto', 'Anciano', 'Atipada'];

        // Devolvemos el resultado
        $actors = $query->latest('id')->paginate(15)->withQueryString();

        return view('admin.actors.index', compact('actors', 'genders', 'voiceAges'));
    }

    // Mostramos el formulario de creación de actor
    public function createActor()
    {
        $this->verificarAdmin();

        $schools = School::orderBy('name')->get();
        $works = Work::orderBy('title')->get();
        $genders = ['Masculino', 'Femenino', 'Otro'];

        //Definimos la lista canónica de edades vocales
        $voiceAges = ['Niño', 'Adolescente', 'Adulto joven', 'Adulto', 'Anciano', 'Atipada'];

        return view('admin.actors.create', compact('schools', 'works', 'genders', 'voiceAges'))
            ->with(['isAdmin' => true]);
    }

    // Guardamos un nuevo actor
    public function storeActor(Request $request)
    {
        // Aseguramos que solo el admin pueda ejecutar esto
        $this->verificarAdmin();

        // 1. Validaciones
        $validator = Validator::make($request->all(), [
            // Datos del Usuario (incluye Nombre completo y Apellidos si se recogen en el campo 'name')
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            // Datos del Actor
            'bio' => ['required', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'audio_path' => ['nullable', 'file', 'mimes:mp3,wav', 'max:5120'],
            'is_available' => ['required', 'boolean'],

            // Arrays JSON
            'genders' => ['required', 'array'],
            'genders.*' => ['string', Rule::in(Actor::getGenderOptions())],
            'voice_ages' => ['required', 'array'],
            'voice_ages.*' => ['string', Rule::in(Actor::getVoiceAgeOptions())],

            // Relaciones Many-to-Many
            'schools' => ['nullable', 'array'],
            'schools.*' => ['exists:schools,id'],
            'works' => ['nullable', 'array'],
            'works.*' => ['exists:works,id'],
            'character_names' => ['nullable', 'array'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 2. Creación del Usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'actor', // Rol fijo
        ]);

        // 3. Manejo de archivos (Usando tus métodos privados)
        $photoPath = $request->hasFile('photo') ?
            $this->guardarArchivo($request->file('photo'), 'photos') : null;
        $audioPath = $request->hasFile('audio_path') ?
            $this->guardarArchivo($request->file('audio_path'), 'audios') : null;

        // 4. Creación del Perfil de Actor
        $actor = Actor::create([
            'user_id' => $user->id,
            'bio' => $request->bio,
            'photo' => $photoPath,
            'audio_path' => $audioPath,
            'genders' => $request->genders,
            'voice_ages' => $request->voice_ages,
            'is_available' => $request->boolean('is_available'),
        ]);

        // 5. Sincronización de Formación (Schools)
        $actor->schools()->sync($request->schools);

        // 6. Sincronización de Obras (Works) con el campo Pivot 'character_name'
        $worksData = [];
        $workIds = $request->works ?? [];
        $characterNames = $request->character_names ?? [];

        foreach ($workIds as $workId) {
            $worksData[$workId] = [
                'character_name' => $characterNames[$workId] ?? null
            ];
        }
        $actor->works()->sync($worksData);

        return redirect()->route('admin.actors')->with('success', 'Actor y usuario creados correctamente.');
    }

    public function editActor(Actor $actor)
    {
        $this->verificarAdmin();

        // 1. Cargamos los datos necesarios para las pestañas de Formación y Experiencia
        $schools = School::orderBy('name')->get();
        $works = Work::orderBy('title')->get();

        // 2. Devolvemos la vista del ADMIN
        return view('admin.actors.edit', compact('actor', 'schools', 'works'));
    }

    /**
     * Procesa la actualización del perfil por parte del ADMIN.
     */
    public function updateActor(Request $request, Actor $actor)
    {
        $this->verificarAdmin();

        // Validaciones del Admin
        $request->validate([
            // Campos de Usuario
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($actor->user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],

            // Campos de Actor
            'is_available' => ['required', 'boolean'],
            'genders' => ['required', 'array'],
            'genders.*' => ['string', Rule::in(Actor::getGenderOptions())],
            'voice_ages' => ['required', 'array'],
            'voice_ages.*' => ['string', Rule::in(Actor::getVoiceAgeOptions())],
            'bio' => ['required', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'audio_path' => ['nullable', 'file', 'mimes:mp3,wav', 'max:5120'],
            'schools' => ['nullable', 'array'],
            'teaching_schools' => ['nullable', 'array'],
            'works' => ['nullable', 'array'],
            'character_names' => ['nullable', 'array'],
        ]);

        // 1. Actualización del Usuario (solo nombre y email)
        $actor->user->name = $request->name;
        $actor->user->email = $request->email;
        if ($request->filled('password')) {
            $actor->user->password = Hash::make($request->password);
        }
        $actor->user->save();

        // 2. Actualización de Archivos y Datos del Actor
        if ($request->hasFile('photo')) {
            $this->eliminarArchivo($actor->photo);
            $actor->photo = $this->guardarArchivo($request->file('photo'), 'photos');
        }

        if ($request->hasFile('audio_path')) {
            $this->eliminarArchivo($actor->audio_path);
            $actor->audio_path = $this->guardarArchivo($request->file('audio_path'), 'audios');
        }

        $actor->fill($request->only([
            'is_available',
            'bio'
        ]));
        $actor->genders = $request->genders ?? [];
        $actor->voice_ages = $request->voice_ages ?? [];
        $actor->save();

        // 3. Sincronización de relaciones Many-to-Many
        $actor->schools()->sync($request->schools ?? []);
        $actor->teachingSchools()->sync($request->teaching_schools ?? []);

        // 4. Sincronización de Obras con character_names (IMPORTANTE)
        $worksData = [];
        $workIds = $request->works ?? [];
        $characterNames = $request->character_names ?? [];

        foreach ($workIds as $workId) {
            $worksData[$workId] = [
                'character_name' => $characterNames[$workId] ?? null
            ];
        }
        $actor->works()->sync($worksData);

        return redirect()->route('admin.actors')->with('success', 'Perfil de actor actualizado correctamente.');
    }

    // Elimina la foto de perfil del actor.
    public function deleteActorPhoto(Actor $actor)
    {
        $this->verificarAdmin();
        $this->eliminarArchivo($actor->photo);
        $actor->photo = null;
        $actor->save();
        return back()->with('success', 'Foto de perfil eliminada.');
    }

    // Elimina la muestra de voz del actor.
    public function deleteActorAudio(Actor $actor)
    {
        $this->verificarAdmin();
        $this->eliminarArchivo($actor->audio_path);
        $actor->audio_path = null;
        $actor->save();
        return back()->with('success', 'Muestra de voz eliminada.');
    }

    // Eliminamos un actor
    public function destroyActor(Actor $actor)
    {
        $this->verificarAdmin();

        // Eliminamos archivos
        $this->eliminarArchivo($actor->photo);
        $this->eliminarArchivo($actor->audio_path);
        $this->eliminarArchivo($actor->voice_pdf_path);

        $userId = $actor->user_id;
        $actor->schools()->detach();
        $actor->works()->detach();
        $actor->teachingSchools()->detach();
        $actor->delete();
        User::find($userId)->delete();

        return redirect()->route('admin.actors')->with('success', 'Perfil de actor eliminado.');
    }

    // ===================================
    // ========== OBRAS CRUD ==========
    // ===================================

    // Listamos todas las obras con filtros
    public function works(Request $request)
    {
        $this->verificarAdmin();

        $query = Work::withCount('actors');

        // 1. Búsqueda por título o autor
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 2. Filtro por Tipo
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 3. Filtro por Año
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        $works = $query->latest()->paginate(15);
        $types = Work::getTypeOptions();

        return view('admin.works.index', compact('works', 'types'));
    }

    // Muestra el formulario de creación de obra
    public function createWork()
    {
        $this->verificarAdmin();
        $types = Work::getTypeOptions();
        return view('admin.works.create', compact('types'));
    }

    // Guarda una nueva obra
    public function storeWork(Request $request)
    {
        $this->verificarAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => ['required', Rule::in(array_keys(Work::getTypeOptions()))],
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'description' => 'nullable|string|max:1000',
            'poster' => 'nullable|image|max:2048',
        ]);

        $work = Work::create($request->only([
            'title',
            'type',
            'year',
            'description'
        ]));

        if ($request->hasFile('poster')) {
            $work->poster = $this->guardarArchivo($request->file('poster'), 'works/posters');
            $work->save();
        }

        return redirect()->route('admin.works')->with('success', 'Obra creada correctamente.');
    }

    // Muestra el formulario de edición de obra
    public function editWork(Work $work)
    {
        $this->verificarAdmin();
        $types = Work::getTypeOptions();
        return view('admin.works.edit', compact('work', 'types'));
    }

    // Actualiza los datos de la obra
    public function updateWork(Request $request, Work $work)
    {
        $this->verificarAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => ['required', Rule::in(array_keys(Work::getTypeOptions()))],
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'description' => 'nullable|string|max:1000',
            'poster' => 'nullable|image|max:2048',
        ]);

        $work->update($request->only([
            'title',
            'type',
            'year',
            'description'
        ]));

        if ($request->hasFile('poster')) {
            $this->eliminarArchivo($work->poster);
            $work->poster = $this->guardarArchivo($request->file('poster'), 'works/posters');
            $work->save();
        }

        return redirect()->route('admin.works')->with('success', 'Obra actualizada correctamente.');
    }

    // Elimina el poster de la obra
    public function deleteWorkPoster(Work $work)
    {
        $this->verificarAdmin();
        $this->eliminarArchivo($work->poster);
        $work->poster = null;
        $work->save();
        return back()->with('success', 'Poster de la obra eliminado.');
    }

    // Elimina la obra
    public function destroyWork(Work $work)
    {
        $this->verificarAdmin();

        // 1. Eliminar archivos (poster)
        $this->eliminarArchivo($work->poster);

        // 2. Desasociar relaciones (actor_work)
        $work->actors()->detach();

        // 3. Eliminar la obra
        $work->delete();

        return redirect()->route('admin.works')->with('success', 'Obra eliminada correctamente.');
    }

    // ========== USUARIOS ==========

    //Listamos todos los usuarios con filtros
    public function users(Request $request)
    {
        $this->verificarAdmin();

        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // ========== MÉTODOS PRIVADOS ==========

    //Verificamos que el usuario sea administrador
    private function verificarAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Solo administradores pueden acceder.');
        }
    }

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
