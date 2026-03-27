<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create() {
        return view('usuarios.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable',
            'address' => 'nullable',
            'license_type' => 'required'
        ]);

        $data['password'] = Hash::make('123456'); //
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'nullable',
            'license_type' => 'required'
        ]);

        $usuario->update($data);
        return redirect()->route('conductores.index')->with('success', 'Datos del conductor actualizados.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        // Seguridad: No permitimos que el usuario actual se elimine a sí mismo
        if (auth()->id() == $usuario->id) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta de usuario.');
        }

        $usuario->delete();
        return redirect()->route('conductores.index')->with('success', 'Conductor eliminado correctamente.');
    }
}