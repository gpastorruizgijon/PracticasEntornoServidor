<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::where('role', 'conductor')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\s\'\-\.]+$/u'],
            'email'        => 'required|email|unique:users',
            'phone'        => ['nullable', 'regex:/^[6789]\d{8}$/'],
            'address'      => ['nullable', 'string', 'min:5', 'regex:/[\p{L}]/u'],
            'license_type' => 'required|in:B,C,C+E',
        ], [
            'name.regex'    => 'El nombre solo puede contener letras y espacios, sin números.',
            'phone.regex'   => 'El teléfono debe tener 9 dígitos y comenzar por 6, 7, 8 o 9.',
            'address.regex' => 'La dirección debe contener texto, no solo números.',
        ]);

        $data['password'] = Hash::make('conductor2024');
        $data['role']     = 'conductor';
        User::create($data);

        return redirect()->route('conductores.index')->with('success', 'Conductor creado');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $data = $request->validate([
            'name'         => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\s\'\-\.]+$/u'],
            'email'        => 'required|email|unique:users,email,' . $id,
            'phone'        => ['nullable', 'regex:/^[6789]\d{8}$/'],
            'license_type' => 'required|in:B,C,C+E',
        ], [
            'name.regex'  => 'El nombre solo puede contener letras y espacios, sin números.',
            'phone.regex' => 'El teléfono debe tener 9 dígitos y comenzar por 6, 7, 8 o 9.',
        ]);

        $usuario->update($data);
        return redirect()->route('conductores.index')->with('success', 'Datos del conductor actualizados.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        if (Auth::id() === $usuario->id) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta de usuario.');
        }

        $usuario->delete();
        return redirect()->route('conductores.index')->with('success', 'Conductor eliminado correctamente.');
    }
}
