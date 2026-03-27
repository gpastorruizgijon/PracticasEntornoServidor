<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RecyclingPlant; //
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index() {
        $plantas = RecyclingPlant::all(); //
        return view('plantas.index', compact('plantas'));
    }

    public function create() {
        return view('plantas.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'city' => 'string',
            'max_capacity_kg' => 'required|numeric',
        ]); //
        
        RecyclingPlant::create($validated); //

        return redirect()->route('plantas.index')->with('success', 'Planta creada con éxito.');
    }

    public function edit($id) {
        $planta = RecyclingPlant::findOrFail($id); //
        return view('plantas.edit', compact('planta'));
    }

    public function update(Request $request, $id) {
        $planta = RecyclingPlant::findOrFail($id); //
        $planta->update($request->all()); //
        return redirect()->route('plantas.index')->with('success', 'Planta actualizada.');
    }

    public function destroy($id) {
        $planta = RecyclingPlant::findOrFail($id); //
        $planta->delete(); //
        return redirect()->route('plantas.index')->with('success', 'Planta eliminada.');
    }
}