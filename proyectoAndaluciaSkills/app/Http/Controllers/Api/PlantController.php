<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RecyclingPlant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    // Solo admin y conductor pueden ver el listado de plantas
    public function index()
    {
        abort_if($this->isUser(), 403, 'Acceso no permitido.');
        $plantas = RecyclingPlant::all();
        return view('plantas.index', compact('plantas'));
    }

    public function create()
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');
        return view('plantas.create');
    }

    public function store(Request $request)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');

        $validated = $request->validate([
            'name'            => 'required|string',
            'city'            => 'required|string',
            'max_capacity_kg' => 'required|numeric|min:1',
        ]);

        RecyclingPlant::create($validated);

        return redirect()->route('plantas.index')->with('success', 'Planta creada con éxito.');
    }

    public function edit($id)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');
        $planta = RecyclingPlant::findOrFail($id);
        return view('plantas.edit', compact('planta'));
    }

    public function update(Request $request, $id)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');

        $planta = RecyclingPlant::findOrFail($id);
        $validated = $request->validate([
            'name'            => 'required|string',
            'city'            => 'required|string',
            'max_capacity_kg' => 'required|numeric|min:1',
        ]);
        $planta->update($validated);

        return redirect()->route('plantas.index')->with('success', 'Planta actualizada.');
    }

    public function destroy($id)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');
        $planta = RecyclingPlant::findOrFail($id);
        $planta->delete();
        return redirect()->route('plantas.index')->with('success', 'Planta eliminada.');
    }
}
