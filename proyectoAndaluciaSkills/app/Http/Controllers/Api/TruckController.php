<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function index() {
        $camiones = Truck::with('driver')->get();
        return view('camiones.index', compact('camiones'));
    }

    public function create() {
        $conductores = User::all();
        return view('camiones.create', compact('conductores'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'plate' => 'required|unique:trucks',
            'model' => 'required',
            'max_load_kg' => 'required|numeric',
            'user_id' => 'required|exists:users,id'
        ]);
        Truck::create($data);
        return redirect()->route('camiones.index')->with('success', 'Camión registrado');
    }

    public function edit(Truck $camione) { // Laravel usa el nombre del recurso en singular
        $conductores = User::all();
        return view('camiones.edit', compact('camione', 'conductores'));
    }

    public function update(Request $request, Truck $camione) {
        $camione->update($request->all());
        return redirect()->route('camiones.index')->with('success', 'Camión actualizado');
    }

    public function destroy(Truck $camione) {
        $camione->delete();
        return redirect()->route('camiones.index')->with('success', 'Camión eliminado');
    }
}