<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment; //
use App\Models\Waste; //
use App\Models\RecyclingPlant; //
use App\Models\Truck; //
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index() {
        $envios = Shipment::with(['waste', 'truck.driver', 'plant'])->get(); //
        return view('envios.index', compact('envios'));
    }

    public function create() {
        $residuos = Waste::all(); //
        $camiones = Truck::all(); //
        $plantas = RecyclingPlant::all(); //
        return view('envios.create', compact('residuos', 'camiones', 'plantas'));
    }

    public function store(Request $request) {
        $request->validate([
            // TRES TABLAS
            'waste_id' => 'required|exists:wastes,id',
            'truck_id' => 'required|exists:trucks,id',
            'recycling_plant_id' => 'required|exists:recycling_plants,id',
            'kilos_transported' => 'required|numeric|min:1',
            'pickup_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:pickup_date',
        ]); //

        $waste = Waste::findOrFail($request->waste_id); //
        $enviadoAnteriormente = Shipment::where('waste_id', $waste->id)->sum('kilos_transported'); //
        $stockDisponible = $waste->kilos - $enviadoAnteriormente; // Porque los fui metiendo cuando lo hice por primera vez, pero en el momento que pense en utilizar el proyecto para entrega digo, fernando va a pensar que sy gilipollas

        if ($request->kilos_transported > $stockDisponible) {
            return back()->withErrors(['kilos_transported' => "Stock insuficiente. Quedan {$stockDisponible}kg."])->withInput();
        }

        $planta = RecyclingPlant::findOrFail($request->recycling_plant_id); //
        $cargaActualPlanta = Shipment::where('recycling_plant_id', $planta->id)->sum('kilos_transported'); //
        
        if (($cargaActualPlanta + $request->kilos_transported) > $planta->max_capacity_kg) {
            $espacioLibre = $planta->max_capacity_kg - $cargaActualPlanta; //
            return back()->withErrors(['recycling_plant_id' => "Capacidad excedida. Espacio libre: {$espacioLibre}kg."])->withInput();
        }

        Shipment::create($request->all()); //
        return redirect()->route('envios.index')->with('success', 'Envío registrado.');
    }
}