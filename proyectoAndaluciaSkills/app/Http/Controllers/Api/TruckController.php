<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    // Solo admin y conductor pueden ver la flota
    public function index()
    {
        abort_if($this->isUser(), 403, 'Acceso no permitido.');
        $camiones = Truck::with('driver')->paginate(15);
        return view('camiones.index', compact('camiones'));
    }

    public function create()
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');
        $conductores = User::where('role', 'conductor')->get();
        return view('camiones.create', compact('conductores'));
    }

    public function store(Request $request)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');

        $data = $request->validate([
            'plate'       => ['required', 'unique:trucks', 'regex:/^\d{4}-?[A-Za-z]{3}$/'],
            'model'       => ['required', 'string', 'min:2', 'max:80', 'regex:/[\p{L}]/u'],
            'max_load_kg' => 'required|numeric|min:500|max:50000',
            'user_id'     => 'required|exists:users,id',
        ], [
            'plate.regex'     => 'La matrícula debe tener el formato 4 dígitos + 3 letras (Ej: 1234-BBB).',
            'model.regex'     => 'El modelo debe contener letras, no puede ser solo números.',
            'max_load_kg.min' => 'La carga mínima es 500 kg.',
            'max_load_kg.max' => 'La carga máxima no puede superar 50.000 kg.',
        ]);

        Truck::create($data);
        return redirect()->route('camiones.index')->with('success', 'Camión registrado');
    }

    public function edit(Truck $camione)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');
        $conductores = User::where('role', 'conductor')->get();
        return view('camiones.edit', compact('camione', 'conductores'));
    }

    public function update(Request $request, Truck $camione)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');

        $data = $request->validate([
            'plate'       => ['required', 'unique:trucks,plate,' . $camione->id, 'regex:/^\d{4}-?[A-Za-z]{3}$/'],
            'model'       => ['required', 'string', 'min:2', 'max:80', 'regex:/[\p{L}]/u'],
            'max_load_kg' => 'required|numeric|min:500|max:50000',
            'user_id'     => 'required|exists:users,id',
        ], [
            'plate.regex'     => 'La matrícula debe tener el formato 4 dígitos + 3 letras (Ej: 1234-BBB).',
            'model.regex'     => 'El modelo debe contener letras, no puede ser solo números.',
            'max_load_kg.min' => 'La carga mínima es 500 kg.',
            'max_load_kg.max' => 'La carga máxima no puede superar 50.000 kg.',
        ]);

        $camione->update($data);
        return redirect()->route('camiones.index')->with('success', 'Camión actualizado');
    }

    public function destroy(Truck $camione)
    {
        abort_unless($this->isAdmin(), 403, 'Acción no permitida.');
        $camione->delete();
        return redirect()->route('camiones.index')->with('success', 'Camión eliminado');
    }
}
