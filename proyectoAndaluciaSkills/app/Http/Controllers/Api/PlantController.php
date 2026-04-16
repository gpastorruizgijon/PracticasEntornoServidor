<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RecyclingPlant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index()
    {
        abort_if($this->isUser(), 403, 'Acceso no permitido.');

        $plantas = RecyclingPlant::withSum(
            ['shipments as carga_activa_kg' => fn($q) => $q->whereIn('status', ['pending', 'in_transit'])],
            'kilos_transported'
        )->paginate(15);

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
            'name'            => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\s\'\-\.]+$/u'],
            'city'            => ['required', 'string', 'min:2', 'max:80',  'regex:/^[\p{L}\s\'\-\.]+$/u'],
            'max_capacity_kg' => 'required|numeric|min:1|max:500000',
        ], [
            'name.regex' => 'El nombre solo puede contener letras, espacios y guiones.',
            'city.regex' => 'La ciudad solo puede contener letras, espacios y guiones (sin números).',
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
            'name'            => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\s\'\-\.]+$/u'],
            'city'            => ['required', 'string', 'min:2', 'max:80',  'regex:/^[\p{L}\s\'\-\.]+$/u'],
            'max_capacity_kg' => 'required|numeric|min:1|max:9999999',
        ], [
            'name.regex' => 'El nombre solo puede contener letras, espacios y guiones.',
            'city.regex' => 'La ciudad solo puede contener letras, espacios y guiones (sin números).',
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
