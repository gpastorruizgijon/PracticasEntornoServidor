<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Waste;

class DashboardController extends Controller
{
    public function index()
    {
        $user = $this->currentUser();

        // ── ADMIN ────────────────────────────────────────────────
        if ($user->isAdmin()) {
            $envios = Shipment::with(['wastes', 'truck', 'plant'])
                ->latest('pickup_date')
                ->limit(10)
                ->get();

            $misResiduos = Waste::where('user_id', $user->id)
                ->with('shipment.plant')
                ->latest()
                ->get();

            return view('dashboard', compact('envios', 'misResiduos'));
        }

        // ── CONDUCTOR ─────────────────────────────────────────────
        if ($user->isConductor()) {
            $envios = Shipment::whereHas('truck', fn($q) => $q->where('user_id', $user->id))
                ->with(['wastes', 'truck', 'plant'])
                ->latest('pickup_date')
                ->get()
                ->groupBy('status');

            $misResiduos = Waste::where('user_id', $user->id)
                ->with('shipment.plant')
                ->latest()
                ->get();

            return view('dashboard', compact('envios', 'misResiduos'));
        }

        // ── USUARIO NORMAL ────────────────────────────────────────
        $misResiduos = Waste::where('user_id', $user->id)
            ->with('shipment.plant')
            ->latest()
            ->get();

        return view('dashboard', compact('misResiduos'));
    }
}
