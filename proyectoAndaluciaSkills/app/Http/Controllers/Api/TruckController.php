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
        $camiones = Truck::with('driver')->get();
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
            'plate'       => 'required|unique:trucks',
            'model'       => 'required',
            'max_load_kg' => 'required|numeric|min:1',
            'user_id'     => 'required|exists:users,id',
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
            'plate'       => 'required|unique:trucks,plate,' . $camione->id,
            'model'       => 'required',
            'max_load_kg' => 'required|numeric|min:1',
            'user_id'     => 'required|exists:users,id',
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
