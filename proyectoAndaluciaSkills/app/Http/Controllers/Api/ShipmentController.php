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
        $envios = Shipment::with(['waste', 'truck.driver', 'plant'])->get(); 
        return view('envios.index', compact('envios'));
    }

    public function create()
    {
        $residuos = Waste::all(); 
        $camiones = Truck::all(); 
        $plantas = RecyclingPlant::all(); 
        return view('envios.create', compact('residuos', 'camiones', 'plantas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'waste_id' => 'required|exists:wastes,id',
            'truck_id' => 'required|exists:trucks,id',
            'recycling_plant_id' => 'required|exists:recycling_plants,id',
            'kilos_transported' => 'required|numeric|min:1',
            'pickup_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:pickup_date',
        ]);

        $waste = Waste::findOrFail($request->waste_id);
        $truck = Truck::findOrFail($request->truck_id);
        $planta = RecyclingPlant::findOrFail($request->recycling_plant_id);

        if ($request->kilos_transported > $truck->max_load_kg) {
            return back()->withErrors([
                'kilos_transported' => "El camión {$truck->plate} no puede cargar tanto. Máximo: {$truck->max_load_kg}kg."
            ])->withInput();
        }

        $enviadoAnteriormente = Shipment::where('waste_id', $waste->id)->sum('kilos_transported');
        $stockDisponible = $waste->kilos - $enviadoAnteriormente;

        if ($request->kilos_transported > $stockDisponible) {
            return back()->withErrors([
                'kilos_transported' => "Stock insuficiente en origen. Solo quedan {$stockDisponible}kg de este residuo."
            ])->withInput();
        }

        $cargaActualPlanta = Shipment::where('recycling_plant_id', $planta->id)->sum('kilos_transported');

        if (($cargaActualPlanta + $request->kilos_transported) > $planta->max_capacity_kg) {
            $espacioLibre = $planta->max_capacity_kg - $cargaActualPlanta;
            return back()->withErrors([
                'recycling_plant_id' => "La planta {$planta->name} está llena. Espacio disponible: {$espacioLibre}kg."
            ])->withInput();
        }

        Shipment::create($request->all());

        return redirect()->route('envios.index')->with('success', 'Envío registrado correctamente y capacidad verificada.');
    }
}
