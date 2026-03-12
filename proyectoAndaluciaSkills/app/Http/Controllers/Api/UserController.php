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
}