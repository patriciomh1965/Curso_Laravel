<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SucursalesRequest;
use App\Models\Sucursales;
use App\Models\Clientes;
use App\Models\Regiones;
use App\Models\Ciudades;
use App\Models\Comunas;

class SucursalesController extends Controller
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

    public function index(Request $request)
    {   
        $clientes = Clientes::where('estado',1)->get();
        $code=$request->session()->get('code');
        $message=$request->session()->get('message');
        return view('layouts.sucursales',['code'=>$code,'message'=>$message,'clientes'=>$clientes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $clientes = Clientes::where('estado',1)->get();
        $regiones = Regiones::get();
        return view('layouts.sucursales_save',['clientes'=>$clientes, 'regiones'=>$regiones]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SucursalesRequest $request)
    {
        try{
            $sucursal = new Sucursales;
            $sucursal->nombre=$request->get('nombre');
            $sucursal->direccion=$request->get('direccion');
            $sucursal->casa_matriz=$request->get('casa_matriz');
            $sucursal->codigo=$request->get('codigo');
            $sucursal->latitud=$request->get('latitud');
            $sucursal->longitud=$request->get('longitud');
            $sucursal->id_comuna=$request->get('comuna');
            $sucursal->estado=1;
            $sucursal->id_cliente=$request->get('clientes');
            $sucursal->save();
            return redirect('sucursales')->with(array('code'=>'200','message'=>'Registrado Creado Correctamente'));
        }catch(\Exception $e){
            return redirect('sucursales')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{    
            $clientes = Clientes::where('estado',1)->get();
            $sucursal = Sucursales::findOrFail($id);
            $regiones = Regiones::get();
            $ciudades = Ciudades::where('id_region',$sucursal->Comunas->Ciudades->id_region)->get();
            $comunas = Comunas::where('id_ciudad',$sucursal->Comunas->Ciudades->id_ciudad)->get();
            return view('layouts.sucursales_save',['sucursal'=>$sucursal,'clientes'=>$clientes,'regiones'=>$regiones,'ciudades'=>$ciudades,'comunas'=>$comunas]); 
        }catch (\ModelNotFoundException $e){   
            return redirect('sucursales')->with(array('code'=>401,'message'=>'Sucursal no encontrado'));
        }catch(\Exception $e){
            return redirect('sucursales')->with(array('code'=>500,'message'=>$e->getCode().' '.$e->getMessage()));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SucursalesRequest $request, $id)
    {
        try{
            $sucursal = Sucursales::findOrFail($id);
            $sucursal->nombre=$request->get('nombre');
            $sucursal->direccion=$request->get('direccion');
            $sucursal->casa_matriz=$request->get('casa_matriz');
            $sucursal->codigo=$request->get('codigo');
            $sucursal->latitud=$request->get('latitud');
            $sucursal->longitud=$request->get('longitud');
            $sucursal->estado=$request->get('estado');
            $sucursal->id_cliente=$request->get('clientes');
            $sucursal->id_comuna=$request->get('comuna');
            $sucursal->save();
            return redirect('sucursales')->with(array('code'=>'200','message'=>'Registrado Actualizado Correctamente'));
        }catch(\Exception $e){
            return redirect('sucursales')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getclientesucursales(Request $request){
        $clientes = Clientes::where('estado',1)->get();
        $cliente = Clientes::where('id_cliente',$request->get('clientes'))->where('estado',1)->first();
        if($cliente)
        {   
            $sucursales = Sucursales::where('id_cliente',$request->get('clientes'))->with('Comunas.Ciudades.Regiones')->get();
            return view('layouts.sucursales',['clientes'=>$clientes,'sucursales'=>$sucursales]);
        }else{
            return view('layouts.sucursales',['clientes'=>$clientes]);
        }
    }
}
