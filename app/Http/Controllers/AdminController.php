<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Work;
use App\Models\User;
use App\Models\Actor;
use App\Models\Request as ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ⚠️ NO USES CONSTRUCTOR CON MIDDLEWARE - causa el error

    public function dashboard()
    {
        // Verificación manual de admin
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $stats = [
            'total_users' => User::count(),
            'total_actors' => User::where('role', 'actor')->count(),
            'total_clients' => User::where('role', 'client')->count(),
            'total_schools' => School::count(),
            'total_works' => Work::count(),
            'total_teacher_actors' => Actor::has('teachingSchools')->count(),
        ];

        // Datos para actividad reciente
        $recentRequests = ContactRequest::with(['client', 'actor'])
            ->latest()
            ->take(5)
            ->get();

        $recentActors = Actor::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests', 'recentActors'));
    }

    public function schools()
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $schools = School::withCount('actors')->latest()->paginate(10);
        return view('admin.schools.index', compact('schools'));
    }

    public function createSchool()
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        return view('admin.schools.create');
    }

    public function storeSchool(Request $request)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url'
        ]);

        // Manejar la subida del logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('schools/logos', 'public');
        }
        School::create($validated);

        return redirect()->route('admin.schools')->with('success', 'Escuela creada exitosamente.');
    }

    public function editSchool(School $school)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        return view('admin.schools.edit', compact('school'));
    }

    public function updateSchool(Request $request, School $school)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url'
        ]);
        // Manejar la subida del logo si se proporciona uno nuevo
if ($request->hasFile('logo')) {
    if ($school->logo) {
        Storage::disk('public')->delete($school->logo);
    }
    $validated['logo'] = $request->file('logo')->store('schools/logos', 'public');
}
        $school->update($validated);

        return redirect()->route('admin.schools')->with('success', 'Escuela actualizada exitosamente.');
    }

    public function destroySchool(School $school)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $school->delete();
        return redirect()->route('admin.schools')->with('success', 'Escuela eliminada exitosamente.');
    }

    // Métodos para works
    public function works(Request $request)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $query = Work::withCount('actors');

        // Filtros
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('year') && $request->year != '') {
            $query->where('year', $request->year);
        }

        // Ordenamiento
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'title':
                    $query->orderBy('title');
                    break;
                case 'actors':
                    $query->orderBy('actors_count', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $works = $query->paginate(10);

        return view('admin.works.index', compact('works'));
    }

    public function createWork()
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $types = Work::getTypeOptions();
    return view('admin.works.create', compact('types'));
    }

    public function storeWork(Request $request)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
    'title' => 'required|string|max:255',
    'type' => 'required|in:movie,series,commercial,animation,videogame,documentary,other', // ← ESPAÑOL
    'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
    'description' => 'nullable|string|max:1000',
    'poster' => 'nullable|image|max:2048'
]);

        // Manejar la subida del póster
        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('works/posters', 'public');
        }

        Work::create($validated);

        return redirect()->route('admin.works')->with('success', 'Obra creada exitosamente.');
    }

    public function editWork(Work $work)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $types = Work::getTypeOptions();
    return view('admin.works.edit', compact('work', 'types'));
    }

    public function updateWork(Request $request, Work $work)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
    'title' => 'required|string|max:255',
    'type' => 'required|in:Película,Serie,Publicidad,Animación,Videojuego', // ← ESPAÑOL
    'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
    'description' => 'nullable|string|max:1000',
    'poster' => 'nullable|image|max:2048'
]);

        // Manejar la subida del póster si se proporciona uno nuevo
        if ($request->hasFile('poster')) {
            // Eliminar el póster anterior si existe
            if ($work->poster) {
                Storage::disk('public')->delete($work->poster);
            }
            $validated['poster'] = $request->file('poster')->store('works/posters', 'public');
        }

        $work->update($validated);

        return redirect()->route('admin.works')->with('success', 'Obra actualizada exitosamente.');
    }

    public function destroyWork(Work $work)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        // Eliminar el póster si existe
        if ($work->poster) {
            Storage::disk('public')->delete($work->poster);
        }

        $work->delete();

        return redirect()->route('admin.works')->with('success', 'Obra eliminada exitosamente.');
    }


    // Métodos para actores
public function actors(Request $request)
{
    if (Auth::user()->role != 'admin') {
        abort(403, 'No autorizado.');
    }

    $query = Actor::with(['user', 'schools', 'works']);

    // Filtros - ACTUALIZAR para usar los nuevos campos JSON
    if ($request->has('gender') && $request->gender != '') {
        $query->whereJsonContains('genders', $request->gender);
    }

    if ($request->has('voice_age') && $request->voice_age != '') {
        $query->whereJsonContains('voice_ages', $request->voice_age);
    }

    if ($request->has('availability') && $request->availability != '') {
        $query->where('is_available', $request->availability == 'available');
    }

    // Ordenamiento
    if ($request->has('sort')) {
        switch ($request->sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name':
                $query->join('users', 'actors.user_id', '=', 'users.id')
                    ->orderBy('users.name');
                break;
            case 'works':
                $query->withCount('works')->orderBy('works_count', 'desc');
                break;
            default:
                $query->latest();
        }
    } else {
        $query->latest();
    }

    $actors = $query->paginate(10);

    $schools = School::all();
    $genders = Actor::getGenderOptions();
    $voiceAges = Actor::getVoiceAgeOptions();

    return view('admin.actors.index', compact('actors', 'schools', 'genders', 'voiceAges'));
}

    public function createActor()
{
    // Mostrar usuarios que pueden ser actores (no admin, no clientes con perfil)
    $availableUsers = User::where('role', '!=', 'admin')
                         ->whereDoesntHave('actorProfile')
                         ->get();
    
    $schools = School::all();
    $works = Work::all();
    $genders = Actor::getGenderOptions();
    $voiceAges = Actor::getVoiceAgeOptions();

    return view('admin.actors.create', compact('availableUsers', 'schools', 'works', 'genders', 'voiceAges'));
}

    // Método para guardar nuevo actor
    public function storeActor(Request $request)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
            'audio_path' => 'nullable|file|mimes:mp3,wav|max:5120',
            'gender' => 'required|in:male,female,other',
            'voice_age' => 'required|in:child,teen,young_adult,adult,senior',
            'is_available' => 'sometimes|boolean',
            'schools' => 'nullable|array',
            'works' => 'nullable|array'
        ]);

        // Verificar que el usuario no tenga ya un perfil de actor
        if (User::find($validated['user_id'])->actorProfile) {
            return redirect()->back()->with('error', 'Este usuario ya tiene un perfil de actor.');
        }

        // Manejar archivos
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('actors/photos', 'public');
        }

        if ($request->hasFile('audio_path')) {
            $validated['audio_path'] = $request->file('audio_path')->store('actors/audios', 'public');
        }

        // Crear el actor
        $actor = Actor::create($validated);

        // Sincronizar relaciones
        if ($request->has('schools')) {
            $actor->schools()->sync($request->schools);
        }

        // Sincronizar obras con nombres de personaje
        if ($request->has('works')) {
            $worksData = [];
            foreach ($request->works as $workId) {
                $worksData[$workId] = [
                    'character_name' => $request->character_names[$workId] ?? null
                ];
            }
            $actor->works()->sync($worksData);
        }

        return redirect()->route('admin.actors')->with('success', 'Actor creado exitosamente.');
    }

    public function editActor(Actor $actor)
{
    $users = User::where('role', 'actor')->get();
    $schools = School::all();
    $works = Work::all();
    $genders = Actor::getGenderOptions();
    $voiceAges = Actor::getVoiceAgeOptions();

    return view('admin.actors.edit', compact('actor', 'users', 'schools', 'works', 'genders', 'voiceAges'));
}

    public function updateActor(Request $request, Actor $actor)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
            'audio_path' => 'nullable|file|mimes:mp3,wav|max:5120',
            'gender' => 'required|in:male,female,other',
            'voice_age' => 'required|in:child,teen,young_adult,adult,senior',
            'is_available' => 'sometimes|boolean',
            'schools' => 'nullable|array',
            'works' => 'nullable|array'
        ]);

        // Manejar archivos
        if ($request->hasFile('photo')) {
            if ($actor->photo) {
                Storage::disk('public')->delete($actor->photo);
            }
            $validated['photo'] = $request->file('photo')->store('actors/photos', 'public');
        }

        if ($request->hasFile('audio_path')) {
            if ($actor->audio_path) {
                Storage::disk('public')->delete($actor->audio_path);
            }
            $validated['audio_path'] = $request->file('audio_path')->store('actors/audios', 'public');
        }

        $actor->update($validated);

        // Sincronizar relaciones
        $actor->schools()->sync($request->schools ?? []);

        // Sincronizar obras con nombres de personaje
        $worksData = [];
        if ($request->has('works')) {
            foreach ($request->works as $workId) {
                $worksData[$workId] = [
                    'character_name' => $request->character_names[$workId] ?? null
                ];
            }
        }
        $actor->works()->sync($worksData);

        return redirect()->route('admin.actors')->with('success', 'Actor actualizado exitosamente.');
    }

    public function destroyActor(Actor $actor)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        // Eliminar archivos si existen
        if ($actor->photo) {
            Storage::disk('public')->delete($actor->photo);
        }
        if ($actor->audio_path) {
            Storage::disk('public')->delete($actor->audio_path);
        }

        $actor->delete();

        return redirect()->route('admin.actors')->with('success', 'Actor eliminado exitosamente.');
    }

    // Métodos para gestión de usuarios
    public function users(Request $request)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $query = User::query();

        // Filtros
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // Crear usuario
    public function createUser() 
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,actor,client'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role']
        ]);

         return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente.');
    }

    public function editUser(User $user)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,actor,client'
        ]);

        // Si se proporciona nueva contraseña
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed'
            ]);
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroyUser(User $user)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        // No permitir eliminar al propio usuario admin
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')->with('error', 'No puedes eliminar tu propio usuario.');
        }

        // Si es actor y tiene perfil, eliminar el perfil primero
        if ($user->role === 'actor' && $user->actorProfile) {
            $user->actorProfile->delete();
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente.');
    }
}
