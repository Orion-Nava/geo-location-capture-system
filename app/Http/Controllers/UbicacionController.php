<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ubicacion;

class UbicacionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'clave' => 'required|string|max:50',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        Ubicacion::create($data);

        return response()->json([
            'message' => 'Ubicación guardada'
        ]);
    }
}