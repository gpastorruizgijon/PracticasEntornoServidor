<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Waste;
use App\Models\RecyclingPlant;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    // Solo admin y conductor pueden ver el listado completo de envíos
    public function index()
    {
        abort_if($this->isUser(), 403, 'Acceso no permitido.');
        $envios = Shipment::with(['wastes', 'truck.driver', 'plant'])->latest('pickup_date')->get();
        return view('envios.index', compact('envios'));
    }

    // Solo admin puede crear envíos
    public function create()
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');

        $tipos = Waste::TYPES;

        $residuosDisponibles = Waste::whereNull('shipment_id')
            ->whereNull('deleted_at')
            ->get()
            ->groupBy('type');

        $camiones = Truck::with('driver')->get();
        $plantas  = RecyclingPlant::all();

        return view('envios.create', compact('tipos', 'residuosDisponibles', 'camiones', 'plantas'));
    }

    public function store(Request $request)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');

        $request->validate([
            'waste_ids'           => 'required|array|min:1',
            'waste_ids.*'         => 'integer|exists:wastes,id',
            'truck_id'            => 'required|exists:trucks,id',
            'recycling_plant_id'  => 'required|exists:recycling_plants,id',
            'pickup_date'         => 'required|date',
            'delivery_date'       => 'nullable|date|after_or_equal:pickup_date',
        ]);

        $wastes = Waste::whereIn('id', $request->waste_ids)
            ->whereNull('shipment_id')
            ->whereNull('deleted_at')
            ->get();

        if ($wastes->count() !== count($request->waste_ids)) {
            return back()->withErrors([
                'waste_ids' => 'Uno o más residuos seleccionados ya no están disponibles.',
            ])->withInput();
        }

        $tipos = $wastes->pluck('type')->unique();
        if ($tipos->count() > 1) {
            return back()->withErrors([
                'waste_ids' => 'Solo puedes incluir residuos del mismo tipo en un envío.',
            ])->withInput();
        }

        $truck  = Truck::findOrFail($request->truck_id);
        $planta = RecyclingPlant::findOrFail($request->recycling_plant_id);
        $totalKilos = $wastes->sum('kilos');

        if ($totalKilos > $truck->max_load_kg) {
            return back()->withErrors([
                'waste_ids' => "El camión {$truck->plate} no puede cargar tanto. Máximo: {$truck->max_load_kg} kg, seleccionado: {$totalKilos} kg.",
            ])->withInput();
        }

        $cargaActualPlanta = Shipment::where('recycling_plant_id', $planta->id)->sum('kilos_transported');
        if (($cargaActualPlanta + $totalKilos) > $planta->max_capacity_kg) {
            $espacioLibre = $planta->max_capacity_kg - $cargaActualPlanta;
            return back()->withErrors([
                'recycling_plant_id' => "La planta {$planta->name} solo tiene {$espacioLibre} kg disponibles.",
            ])->withInput();
        }

        $shipment = Shipment::create([
            'truck_id'           => $request->truck_id,
            'recycling_plant_id' => $request->recycling_plant_id,
            'type'               => $tipos->first(),
            'kilos_transported'  => $totalKilos,
            'pickup_date'        => $request->pickup_date,
            'delivery_date'      => $request->delivery_date,
            'status'             => 'pending',
        ]);

        Waste::whereIn('id', $wastes->pluck('id'))->update(['shipment_id' => $shipment->id]);

        return redirect()->route('envios.index')->with('success', 'Envío registrado correctamente.');
    }

    public function destroy(Shipment $envio)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');

        Waste::where('shipment_id', $envio->id)->update(['shipment_id' => null]);
        $envio->delete();

        return redirect()->route('envios.index')->with('success', 'Envío anulado. Los residuos han vuelto a estar disponibles.');
    }
}
