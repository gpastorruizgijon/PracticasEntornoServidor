<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // Clave predefinida que deben introducir los conductores al registrarse
    const CONDUCTOR_PASSWORD = 'conductor2024';

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $isConductor = $request->input('is_conductor') === '1';

        // Campos comunes
        $request->validate([
            'name'  => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\s\'\-\.]+$/u'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        ], [
            'name.regex' => 'El nombre solo puede contener letras y espacios, sin números.',
        ]);

        if ($isConductor) {
            // Para conductores: validar clave predefinida de empresa
            if ($request->input('conductor_key') !== self::CONDUCTOR_PASSWORD) {
                throw ValidationException::withMessages([
                    'conductor_key' => 'Clave de conductor incorrecta. Contacta con el administrador.',
                ]);
            }
            $role     = 'conductor';
            $password = self::CONDUCTOR_PASSWORD;
        } else {
            // Para usuarios normales: validar contraseña con reglas estándar
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            $role     = 'user';
            $password = $request->input('password');
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($password),
            'role'     => $role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
