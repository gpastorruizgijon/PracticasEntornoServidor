<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Waste;
use Illuminate\Http\Request;

class WasteController extends Controller
{
    public function index() { 
        $residuos = Waste::all();
        return view('residuos.index', compact('residuos')); 
    }

    public function create() {
        return view('residuos.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'type' => 'required',
            'kilos' => 'required|numeric',
            'origin_address' => 'required',
            'is_hazardous' => 'boolean'
        ]);
        Waste::create($data);
        return redirect()->route('residuos.index')->with('success', 'Residuo registrado');
    }

    public function edit(Waste $residuo) {
        return view('residuos.edit', compact('residuo'));
    }

    public function update(Request $request, Waste $residuo) {
        $residuo->update($request->all());
        return redirect()->route('residuos.index')->with('success', 'Residuo actualizado');
    }

    public function destroy(Waste $residuo) {
        $residuo->delete();
        return redirect()->route('residuos.index')->with('success', 'Residuo eliminado');
    }
}