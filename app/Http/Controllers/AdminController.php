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

    // ========== ESCUELAS ==========

    //Listamos todas las escuelas con filtros
    public function schools(Request $request)
    {
        $this->verificarAdmin();

        $query = School::withCount(['actors', 'teachers']);

        //Aplicamos filtros si se han especificado
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        //Ordenamos los resultados
        $query = $this->ordenar($query, $request->sort, [
            'name' => 'name',
            'actors' => 'actors_count',
            'oldest' => 'created_at'
        ]);

        $schools = $query->paginate(10);
        $cities = School::distinct('city')->orderBy('city')->pluck('city');

        return view('admin.schools.index', compact('schools', 'cities'));
    }

    //Mostramos el formulario para crear una escuela
    public function createSchool()
    {
        $this->verificarAdmin();
        return view('admin.schools.create');
    }

    //Guardamos una nueva escuela
    public function storeSchool(Request $request)
    {
        $this->verificarAdmin();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url'
        ], [
            //Mensajes de validación en español
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => [
                'string' => 'El campo :attribute no puede tener más de :max caracteres.',
                'file' => 'El archivo :attribute no puede pesar más de :max KB.',
            ],
            'integer' => 'El campo :attribute debe ser un número.',
            'min' => 'El campo :attribute debe ser al menos :min.',
            'url' => 'El campo :attribute debe ser una URL válida.',
            'image' => 'El campo :attribute debe ser una imagen.',
        ], [
            //Nombres de campos en español
            'name' => 'nombre',
            'city' => 'ciudad',
            'description' => 'descripción',
            'founded_year' => 'año de fundación',
            'logo' => 'logo',
            'website' => 'sitio web',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->guardarArchivo($request->file('logo'), 'schools/logos');
        }

        School::create($data);

        return redirect()->route('admin.schools')->with('success', 'Escuela creada.');
    }

    //Mostramos el formulario para editar una escuela
    public function editSchool(School $school)
    {
        $this->verificarAdmin();
        return view('admin.schools.edit', compact('school'));
    }

    //Actualizamos una escuela existente
    public function updateSchool(Request $request, School $school)
    {
        $this->verificarAdmin();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url'
        ], [
            //Mensajes de validación en español
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => [
                'string' => 'El campo :attribute no puede tener más de :max caracteres.',
                'file' => 'El archivo :attribute no puede pesar más de :max KB.',
            ],
            'integer' => 'El campo :attribute debe ser un número.',
            'min' => 'El campo :attribute debe ser al menos :min.',
            'url' => 'El campo :attribute debe ser una URL válida.',
            'image' => 'El campo :attribute debe ser una imagen.',
        ], [
            //Nombres de campos en español
            'name' => 'nombre',
            'city' => 'ciudad',
            'description' => 'descripción',
            'founded_year' => 'año de fundación',
            'logo' => 'logo',
            'website' => 'sitio web',
        ]);

        if ($request->hasFile('logo')) {
            $this->eliminarArchivo($school->logo);
            $data['logo'] = $this->guardarArchivo($request->file('logo'), 'schools/logos');
        }

        $school->update($data);

        return redirect()->route('admin.schools')->with('success', 'Escuela actualizada.');
    }

    //Eliminamos una escuela
    public function destroySchool(School $school)
    {
        $this->verificarAdmin();

        $school->delete();
        return redirect()->route('admin.schools')->with('success', 'Escuela eliminada.');
    }

    // ========== OBRAS ==========

    //Listamos todas las obras con filtros
    public function works(Request $request)
    {
        $this->verificarAdmin();

        $query = Work::withCount('actors');

        //Aplicamos filtros si se han especificado
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        //Ordenamos los resultados
        $query = $this->ordenar($query, $request->sort, [
            'title' => 'title',
            'actors' => 'actors_count',
            'oldest' => 'created_at'
        ]);

        $works = $query->paginate(10);
        $types = Work::getTypeOptions();

        return view('admin.works.index', compact('works', 'types'));
    }

    //Mostramos el formulario para crear una obra
    public function createWork()
    {
        $this->verificarAdmin();
        $types = Work::getTypeOptions();
        return view('admin.works.create', compact('types'));
    }

    //Guardamos una nueva obra
    public function storeWork(Request $request)
    {
        $this->verificarAdmin();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', array_keys(Work::getTypeOptions())),
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'description' => 'nullable|string|max:1000',
            'poster' => 'nullable|image|max:2048'
        ], [
            //Mensajes de validación en español
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => [
                'string' => 'El campo :attribute no puede tener más de :max caracteres.',
                'file' => 'El archivo :attribute no puede pesar más de :max KB.',
            ],
            'integer' => 'El campo :attribute debe ser un número.',
            'min' => 'El campo :attribute debe ser al menos :min.',
            'in' => 'El tipo seleccionado no es válido.',
            'image' => 'El campo :attribute debe ser una imagen.',
        ], [
            //Nombres de campos en español
            'title' => 'título',
            'type' => 'tipo',
            'year' => 'año',
            'description' => 'descripción',
            'poster' => 'póster',
        ]);

        if ($request->hasFile('poster')) {
            $data['poster'] = $this->guardarArchivo($request->file('poster'), 'works/posters');
        }

        Work::create($data);

        return redirect()->route('admin.works')->with('success', 'Obra creada.');
    }

    //Mostramos el formulario para editar una obra
    public function editWork(Work $work)
    {
        $this->verificarAdmin();
        $types = Work::getTypeOptions();
        return view('admin.works.edit', compact('work', 'types'));
    }

    //Actualizamos una obra existente
    public function updateWork(Request $request, Work $work)
    {
        $this->verificarAdmin();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', array_keys(Work::getTypeOptions())),
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'description' => 'nullable|string|max:1000',
            'poster' => 'nullable|image|max:2048'
        ], [
            //Mensajes de validación en español
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => [
                'string' => 'El campo :attribute no puede tener más de :max caracteres.',
                'file' => 'El archivo :attribute no puede pesar más de :max KB.',
            ],
            'integer' => 'El campo :attribute debe ser un número.',
            'min' => 'El campo :attribute debe ser al menos :min.',
            'in' => 'El tipo seleccionado no es válido.',
            'image' => 'El campo :attribute debe ser una imagen.',
        ], [
            //Nombres de campos en español
            'title' => 'título',
            'type' => 'tipo',
            'year' => 'año',
            'description' => 'descripción',
            'poster' => 'póster',
        ]);

        if ($request->hasFile('poster')) {
            $this->eliminarArchivo($work->poster);
            $data['poster'] = $this->guardarArchivo($request->file('poster'), 'works/posters');
        }

        $work->update($data);

        return redirect()->route('admin.works')->with('success', 'Obra actualizada.');
    }

    //Eliminamos una obra
    public function destroyWork(Work $work)
    {
        $this->verificarAdmin();

        $this->eliminarArchivo($work->poster);
        $work->delete();

        return redirect()->route('admin.works')->with('success', 'Obra eliminada.');
    }

    // ========== ACTORES ==========

    //Listamos todos los actores con filtros
    public function actors(Request $request)
    {
        $this->verificarAdmin();

        $query = Actor::with(['user', 'schools']);

        //Aplicamos filtros si se han especificado
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('availability')) {
            $query->where('is_available', $request->availability == 'available');
        }

        $actors = $query->paginate(10);
        $genders = Actor::getGenderOptions();
        $voiceAges = Actor::getVoiceAgeOptions();

        return view('admin.actors.index', compact('actors', 'genders', 'voiceAges'));
    }

    //Mostramos formulario para crear actor (admin)
    public function createActor()
    {
        $this->verificarAdmin();

        $data = [
            'schools' => School::all(),
            'works' => Work::all(),
            'genders' => Actor::getGenderOptions(),
            'voiceAges' => Actor::getVoiceAgeOptions(),
        ];

        return view('admin.actors.create', $data);
    }

    //Guardamos nuevo actor creado por admin
    public function storeActor(Request $request)
    {
        $this->verificarAdmin();

        // Primero crear usuario
        $userData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'email' => 'El campo :attribute debe ser un email válido.',
            'unique' => 'Este :attribute ya está registrado.',
            'min' => [
                'string' => 'El campo :attribute debe tener al menos :min caracteres.',
            ],
            'confirmed' => 'Las contraseñas no coinciden.',
        ], [
            'name' => 'nombre',
            'email' => 'email',
            'password' => 'contraseña',
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'role' => 'actor',
        ]);

        // Luego validar datos del actor
        $actorData = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
            'audio_path' => 'nullable|file|mimes:mp3,wav|max:5120',
            'genders' => 'required|array',
            'voice_ages' => 'required|array',
            'is_available' => 'sometimes|boolean',
            'schools' => 'nullable|array',
            'works' => 'nullable|array'
        ], [
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
            'bio' => 'biografía',
            'photo' => 'foto',
            'audio_path' => 'audio',
            'genders' => 'géneros',
            'voice_ages' => 'edades de voz',
            'is_available' => 'disponibilidad',
            'schools' => 'escuelas',
            'works' => 'trabajos',
        ]);

        // Crear actor
        $actor = new Actor();
        $actor->user_id = $user->id;
        $actor->bio = $actorData['bio'] ?? null;
        $actor->genders = $actorData['genders'];
        $actor->voice_ages = $actorData['voice_ages'];
        $actor->is_available = $request->has('is_available');

        // Guardar archivos
        if ($request->hasFile('photo')) {
            $actor->photo = $this->guardarArchivo($request->file('photo'), 'actors/photos');
        }

        if ($request->hasFile('audio_path')) {
            $actor->audio_path = $this->guardarArchivo($request->file('audio_path'), 'actors/audios');
        }

        $actor->save();

        // Asociar relaciones
        if ($request->has('schools')) {
            $actor->schools()->sync($request->schools);
        }

        if ($request->has('works')) {
            $actor->agregarTrabajos($request->works, $request->character_names ?? []);
        }

        return redirect()->route('admin.actors')->with('success', 'Actor y usuario creados exitosamente.');
    }

    //Mostramos el formulario para editar un actor
    public function editActor(Actor $actor)
    {
        $this->verificarAdmin();

        $data = [
            'actor' => $actor,
            'schools' => School::all(),
            'works' => Work::all(),
            'genders' => Actor::getGenderOptions(),
            'voiceAges' => Actor::getVoiceAgeOptions(),
            'isAdmin' => true
        ];

        return view('actors.edit', $data);
    }

    //Actualizamos un actor (versión simplificada para admin)
    public function updateActor(Request $request, Actor $actor)
    {
        $this->verificarAdmin();

        $data = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'genders' => 'required|array|min:1',
            'voice_ages' => 'required|array|min:1',
            'is_available' => 'required|boolean',
            'schools' => 'nullable|array'
        ], [
            //Mensajes de validación en español
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => [
                'string' => 'El campo :attribute no puede tener más de :max caracteres.',
            ],
            'array' => 'El campo :attribute debe ser una lista.',
            'min' => [
                'array' => 'El campo :attribute debe tener al menos :min elemento.',
            ],
            'boolean' => 'El campo :attribute debe ser sí o no.',
        ], [
            //Nombres de campos en español
            'bio' => 'biografía',
            'genders' => 'géneros',
            'voice_ages' => 'edades de voz',
            'is_available' => 'disponibilidad',
            'schools' => 'escuelas',
        ]);

        //Actualizamos los datos básicos (sin archivos para simplificar)
        $actor->update($data);

        //Sincronizamos las escuelas
        $actor->schools()->sync($request->schools ?? []);

        return redirect()->route('admin.actors')->with('success', 'Actor actualizado.');
    }

    //Eliminamos un actor
    public function destroyActor(Actor $actor)
    {
        $this->verificarAdmin();

        //Eliminamos los archivos si existen
        $this->eliminarArchivo($actor->photo);
        $this->eliminarArchivo($actor->audio_path);

        $actor->delete();

        return redirect()->route('admin.actors')->with('success', 'Actor eliminado.');
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
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
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

    //Ordenamos una consulta según el parámetro recibido
    private function ordenar($query, $sort, $options = [])
    {
        switch ($sort) {
            case 'oldest':
                return $query->oldest();
            case 'title':
            case 'name':
                return $query->orderBy($options[$sort] ?? $sort);
            case 'actors':
                return $query->orderBy($options['actors'], 'desc');
            default:
                return $query->latest();
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
