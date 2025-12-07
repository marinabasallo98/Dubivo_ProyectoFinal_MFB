<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //Mostramos el formulario para actores
    public function showActorForm()
    {
        return view('auth.register-actor');
    }

    //Mostramos el formulario para clientes
    public function showClientForm()
    {
        return view('auth.register-client');
    }

    //Procesamos el registro de un actor
    public function registerActor(Request $request)
    {
        //Validamos los datos recibidos
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ], [
            //Mensajes de validación en español
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'email' => 'El campo :attribute debe ser un email válido.',
            'unique' => 'Este :attribute ya está registrado.',
            'min' => [
                'string' => 'El campo :attribute debe tener al menos :min caracteres.',
            ],
            'max' => [
                'string' => 'El campo :attribute no puede tener más de :max caracteres.',
            ],
            'confirmed' => 'Las contraseñas no coinciden.',
        ], [
            //Nombres de campos en español
            'name' => 'nombre',
            'email' => 'email',
            'password' => 'contraseña',
        ]);

        //Creamos el usuario actor
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'actor',
        ]);

/*         //Creamos su perfil de actor vacío
        Actor::create([
            'user_id' => $user->id,
            'bio' => null,
            'genders' => [],
            'voice_ages' => [],
            'is_available' => true,
        ]); */

        //Logueamos al usuario automáticamente
        Auth::login($user);

        //Lo enviamos a completar su perfil
        return redirect()->route('actors.create')
            ->with('success', '¡Cuenta creada! Ahora completa tu perfil.');
    }

    //Procesamos el registro de un cliente
    public function registerClient(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ], [
            //Mensajes de validación en español (los mismos que para actor)
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'email' => 'El campo :attribute debe ser un email válido.',
            'unique' => 'Este :attribute ya está registrado.',
            'min' => [
                'string' => 'El campo :attribute debe tener al menos :min caracteres.',
            ],
            'max' => [
                'string' => 'El campo :attribute no puede tener más de :max caracteres.',
            ],
            'confirmed' => 'Las contraseñas no coinciden.',
        ], [
            //Nombres de campos en español
            'name' => 'nombre',
            'email' => 'email',
            'password' => 'contraseña',
        ]);

        //Creamos el usuario cliente
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'client',
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', '¡Bienvenido!');
    }
}