<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Waste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WasteController extends Controller
{
    public function index(Request $request)
    {
        if ($this->isUser()) {
            return redirect()->route('dashboard');
        }

        $tipoFiltro = $request->get('tipo');

        // SoftDeletes global scope excluye deleted_at automáticamente
        $disponiblesQuery = Waste::whereNull('shipment_id');
        if ($tipoFiltro) {
            $disponiblesQuery->where('type', $tipoFiltro);
        }
        $disponibles = $disponiblesQuery->get()->groupBy('type');

        $enTransitoQuery = Waste::whereHas('shipment', fn($q) => $q->where('status', 'in_transit'))
            ->with('shipment.plant');
        if ($tipoFiltro) {
            $enTransitoQuery->where('type', $tipoFiltro);
        }
        $enTransito = $enTransitoQuery->get();

        $entregadosQuery = Waste::whereHas('shipment', fn($q) => $q->where('status', 'delivered'))
            ->with('shipment.plant');
        if ($tipoFiltro) {
            $entregadosQuery->where('type', $tipoFiltro);
        }
        $entregados = $entregadosQuery->get();

        $tipos = Waste::TYPES;
        return view('residuos.index', compact('disponibles', 'enTransito', 'entregados', 'tipoFiltro', 'tipos'));
    }

    public function create()
    {
        $tipos = Waste::TYPES;
        return view('residuos.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'           => 'required|in:' . implode(',', Waste::TYPES),
            'kilos'          => 'required|numeric|min:0.1|max:99999',
            'origin_address' => ['required', 'string', 'min:5', 'regex:/[\p{L}]/u'],
            'is_hazardous'   => 'boolean',
        ], [
            'origin_address.regex' => 'La dirección debe contener texto, no solo números.',
            'origin_address.min'   => 'La dirección debe tener al menos 5 caracteres.',
            'kilos.max'            => 'El peso no puede superar 99.999 kg.',
        ]);

        $data['user_id']      = Auth::id();
        $data['is_hazardous'] = $request->boolean('is_hazardous');

        Waste::create($data);

        $redirect = $this->isUser()
            ? route('dashboard')
            : route('residuos.index');

        return redirect($redirect)->with('success', 'Residuo registrado correctamente.');
    }

    public function edit(Waste $residuo)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');
        $tipos = Waste::TYPES;
        return view('residuos.edit', compact('residuo', 'tipos'));
    }

    public function update(Request $request, Waste $residuo)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');

        $data = $request->validate([
            'type'           => 'required|in:' . implode(',', Waste::TYPES),
            'kilos'          => 'required|numeric|min:0.1|max:99999',
            'origin_address' => ['required', 'string', 'min:5', 'regex:/[\p{L}]/u'],
            'is_hazardous'   => 'boolean',
        ], [
            'origin_address.regex' => 'La dirección debe contener texto, no solo números.',
            'origin_address.min'   => 'La dirección debe tener al menos 5 caracteres.',
            'kilos.max'            => 'El peso no puede superar 99.999 kg.',
        ]);
        $data['is_hazardous'] = $request->boolean('is_hazardous');

        $residuo->update($data);
        return redirect()->route('residuos.index')->with('success', 'Residuo actualizado.');
    }

    public function destroy(Waste $residuo)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');
        $residuo->delete();
        return redirect()->route('residuos.index')->with('success', 'Residuo eliminado.');
    }
}
