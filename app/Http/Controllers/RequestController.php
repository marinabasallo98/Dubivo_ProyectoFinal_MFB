<?php

namespace App\Http\Controllers;

use App\Models\Request as ContactRequest;
use App\Models\User;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = ContactRequest::query();
        
        if ($user->role == 'actor') {
            // Para actores, mostrar requests donde ellos son el actor
            $query->where('actor_id', $user->actor->id) // Asumiendo que User tiene relación actor
                  ->with('client');
        } else if ($user->role == 'client') {
            // Para clientes, mostrar requests donde ellos son el cliente
            $query->where('client_id', $user->id)
                  ->with('actor.user');
        } else {
            // Admin ve todos
            $query->with(['client', 'actor.user']);
        }

        // Filtro por estado
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $requests = $query->latest()->paginate(10);

        return view('requests.index', compact('requests'));
    }

    public function create(Actor $actor)
    {
        // Verificar que el usuario es cliente
        if (Auth::user()->role != 'client') {
            return redirect()->back()->with('error', 'Solo los clientes pueden enviar solicitudes.');
        }

        // Verificar que el actor existe y está disponible
        if (!$actor->is_available) {
            return redirect()->back()->with('error', 'Este actor no está disponible.');
        }

        return view('requests.create', compact('actor'));
    }

    public function store(Request $request, Actor $actor)
    {
        // Verificar que el usuario es cliente
        if (Auth::user()->role != 'client') {
            return redirect()->back()->with('error', 'Solo los clientes pueden enviar solicitudes.');
        }

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        ContactRequest::create([
            'client_id' => Auth::id(),
            'actor_id' => $actor->id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'pending'
        ]);

        return redirect()->route('actors.show', $actor->id)
                    ->with('success', 'Solicitud enviada exitosamente.');
    }

    public function updateStatus(ContactRequest $contactRequest, $status)
    {
        // Verificar que el usuario es el actor dueño de la request o admin
        $user = Auth::user();
        if ($user->role == 'actor' && $user->actor->id != $contactRequest->actor_id) {
            abort(403, 'No autorizado.');
        }

        if (!in_array($status, ['accepted', 'rejected'])) {
            return redirect()->back()->with('error', 'Estado inválido.');
        }

        $contactRequest->update(['status' => $status]);

        return redirect()->back()->with('success', "Solicitud {$status}.");
    }

    public function destroy(ContactRequest $contactRequest)
    {
        $user = Auth::user();
        
        // Verificar permisos: cliente dueño, actor dueño, o admin
        if ($user->role == 'client' && $user->id != $contactRequest->client_id) {
            abort(403, 'No autorizado.');
        }
        
        if ($user->role == 'actor' && $user->actor->id != $contactRequest->actor_id) {
            abort(403, 'No autorizado.');
        }

        $contactRequest->delete();

        return redirect()->back()->with('success', 'Solicitud eliminada.');
    }
}