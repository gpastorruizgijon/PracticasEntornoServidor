<?php
 namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        // Eloquent: Traemos todas las ofertas de la BD
        $offers = Offer::all();

        // Retornamos la vista pasándole los datos
        return view('offers.index', compact('offers'));
    }
} 
?>