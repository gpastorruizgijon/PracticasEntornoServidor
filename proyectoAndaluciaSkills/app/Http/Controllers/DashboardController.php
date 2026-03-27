<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waste; // Asegúrate de importar tus modelos
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // El Jefe ve todo
            $residuos = Waste::all();
            $totalConductores = User::where('role', 'conductor')->count();
        } else {
            // El Conductor solo ve sus residuos/envíos
            // (Asumiendo que Waste tiene user_id)
            $residuos = Waste::where('user_id', $user->id)->get();
            $totalConductores = 1; 
        }

        return view('dashboard', compact('residuos', 'totalConductores'));
    }
}
