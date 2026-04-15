<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Waste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WasteController extends Controller
{
    // Usuarios normales son redirigidos al dashboard (sus residuos están allí)
    public function index()
    {
        if ($this->isUser()) {
            return redirect()->route('dashboard');
        }

        $disponibles = Waste::whereNull('shipment_id')
            ->whereNull('deleted_at')
            ->get()
            ->groupBy('type');

        $enTransito = Waste::whereHas('shipment', fn($q) => $q->where('status', 'in_transit'))
            ->with('shipment.plant')
            ->whereNull('deleted_at')
            ->get();

        $entregados = Waste::whereHas('shipment', fn($q) => $q->where('status', 'delivered'))
            ->with('shipment.plant')
            ->whereNull('deleted_at')
            ->get();

        return view('residuos.index', compact('disponibles', 'enTransito', 'entregados'));
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
            'kilos'          => 'required|numeric|min:0.1',
            'origin_address' => 'required|string',
            'is_hazardous'   => 'boolean',
        ]);

        $data['user_id']      = Auth::id();
        $data['is_hazardous'] = $request->boolean('is_hazardous');

        Waste::create($data);

        // Usuarios normales vuelven a su dashboard; admin y conductor al listado
        $redirect = $this->isUser()
            ? route('dashboard')
            : route('residuos.index');

        return redirect($redirect)->with('success', 'Residuo registrado correctamente.');
    }

    // Solo admin puede editar o borrar residuos
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
            'kilos'          => 'required|numeric|min:0.1',
            'origin_address' => 'required|string',
            'is_hazardous'   => 'boolean',
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
