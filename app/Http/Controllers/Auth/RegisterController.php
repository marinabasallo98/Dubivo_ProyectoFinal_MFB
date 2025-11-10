<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Mostrar formulario para actores
    public function showActorRegistrationForm()
    {
        return view('auth.register-actor');
    }

    // Mostrar formulario para clientes
    public function showClientRegistrationForm()
    {
        return view('auth.register-client');
    }

    // Registrar actor
    public function registerActor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear usuario actor
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'actor',
        ]);

        // Crear perfil de actor automáticamente y guardar la variable
        $actor = Actor::create([
            'user_id' => $user->id,
            'bio' => null,
            'genders' => [],
            'voice_ages' => [],
            'is_available' => true,
        ]);

        // Login automático (usando Auth facade)
        Auth::login($user);

        return redirect()->route('actors.edit', $actor)->with('success', '¡Perfil de actor creado! Completa tu información adicional.');
    }

    // Registrar cliente
    public function registerClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear usuario cliente
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client',
        ]);

        // Login automático (usando Auth facade)
        Auth::login($user); // ← CORREGIDO

        return redirect('/dashboard')->with('success', '¡Cuenta de cliente creada exitosamente!');
    }
}