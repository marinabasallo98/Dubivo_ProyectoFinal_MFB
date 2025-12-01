<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    //Permitimos que cualquier usuario haga esta solicitud
    public function authorize(): bool
    {
        return true;
    }

    //Definimos las reglas de validación
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    //Personalizamos los mensajes de error en español
    public function messages(): array
    {
        return [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ser un email válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ];
    }

    //Intentamos autenticar al usuario
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            //Mostramos error en español si las credenciales fallan
            throw ValidationException::withMessages([
                'email' => 'Email o contraseña incorrectos.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    //Verificamos que no haya demasiados intentos fallidos
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        //Mensaje simple en español para demasiados intentos
        throw ValidationException::withMessages([
            'email' => 'Demasiados intentos. Inténtalo de nuevo más tarde.',
        ]);
    }

    //Generamos una clave única para limitar intentos
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}