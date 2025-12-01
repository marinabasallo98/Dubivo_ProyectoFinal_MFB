<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        //Si no hay usuario logueado, vamos a la página principal
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();
        
        //Los administradores van a su panel especial
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        //Para actores y clientes, mostramos actores destacados
        $featuredActors = Actor::where('is_available', true)
            ->with(['user', 'works'])
            ->latest()
            ->limit(3)
            ->get();

        return view('dashboard', compact('user', 'featuredActors'));
    }
}