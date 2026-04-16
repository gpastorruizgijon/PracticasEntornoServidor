<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Waste;
use App\Models\RecyclingPlant;
use App\Models\Truck;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        abort_if($this->isUser(), 403, 'Acceso no permitido.');
        $envios = Shipment::with(['wastes', 'truck.driver', 'plant'])->latest('pickup_date')->paginate(15);
        return view('envios.index', compact('envios'));
    }

    public function create()
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');

        $tipos = Waste::TYPES;

        // SoftDeletes global scope ya excluye deleted_at automáticamente
        $residuosDisponibles = Waste::whereNull('shipment_id')
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

        // Residuos peligrosos requieren licencia C+E
        if ($wastes->where('is_hazardous', true)->isNotEmpty() && $truck->driver?->license_type !== 'C+E') {
            $licencia = $truck->driver?->license_type ?? 'sin licencia asignada';
            return back()->withErrors([
                'truck_id' => "Los residuos peligrosos requieren licencia C+E. El conductor de este camión tiene: {$licencia}.",
            ])->withInput();
        }

        if ($totalKilos > $truck->max_load_kg) {
            return back()->withErrors([
                'waste_ids' => "El camión {$truck->plate} no puede cargar tanto. Máximo: {$truck->max_load_kg} kg, seleccionado: {$totalKilos} kg.",
            ])->withInput();
        }

        // Solo envíos activos (pending + in_transit) cuentan para la capacidad
        $cargaActualPlanta = Shipment::where('recycling_plant_id', $planta->id)
            ->whereIn('status', ['pending', 'in_transit'])
            ->sum('kilos_transported');

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

    public function updateStatus(Shipment $envio)
    {
        abort_if($this->isUser(), 403, 'Acción no permitida.');

        // El conductor solo puede avanzar sus propios envíos
        if ($this->isConductor()) {
            abort_unless(
                $envio->truck?->user_id === $this->currentUser()->id,
                403,
                'No tienes permiso para modificar este envío.'
            );
        }

        $next = match($envio->status) {
            'pending'    => 'in_transit',
            'in_transit' => 'delivered',
            default      => null,
        };

        if (!$next) {
            return back()->with('error', 'Este envío ya fue entregado y no puede avanzar más.');
        }

        $envio->update(['status' => $next]);

        $label = $next === 'in_transit' ? 'En Tránsito' : 'Entregado';
        return back()->with('success', "Estado del envío actualizado a: {$label}.");
    }

    public function destroy(Shipment $envio)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');

        Waste::where('shipment_id', $envio->id)->update(['shipment_id' => null]);
        $envio->delete();

        return redirect()->route('envios.index')->with('success', 'Envío anulado. Los residuos han vuelto a estar disponibles.');
    }
}
