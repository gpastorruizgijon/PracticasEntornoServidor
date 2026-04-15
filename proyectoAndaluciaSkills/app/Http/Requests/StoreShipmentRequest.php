<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function rules(): array
{
    return [
        'waste_id' => 'required|exists:wastes,id',
        'truck_id' => 'required|exists:trucks,id',
        'recycling_plant_id' => 'required|exists:recycling_plants,id',
        'pickup_date' => 'required|date',
        'kilos_transported' => [
            'required',
            'numeric',
            'min:0.1',
            function ($attribute, $value, $fail) {
                $truck = \App\Models\Truck::find($this->truck_id);
                if ($truck && $value > $truck->max_load_kg) {
                    $fail("¡Sobrecarga! El camión {$truck->plate} solo soporta {$truck->max_load_kg}kg.");
                }
            },
        ],
    ];

}
}
