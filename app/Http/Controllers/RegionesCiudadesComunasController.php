<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regiones;
use App\Models\Ciudades;
use App\Models\Comunas;

class RegionesCiudadesComunasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getregiones()
    {
        $regiones = Regiones::get();
        return response()->json($regiones);
    }

    public function getciudades($id)
    {
        $ciudades = Ciudades::where('id_region',$id)->get();
        return response()->json($ciudades);
    }

    public function getcomunas($id)
    {
        $comunas = Comunas::where('id_ciudad',$id)->get();
        return response()->json($comunas);
    }
}
