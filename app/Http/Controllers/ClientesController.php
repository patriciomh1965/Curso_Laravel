<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientesRequest;
use App\Models\Clientes;
use App\Models\Sucursales;
use App\Models\ClientesSucursales;
use File;

class ClientesController extends Controller
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
        $clientes=Clientes::all();
        $code=$request->session()->get('code');
        $message=$request->session()->get('message');
        return view('layouts.clientes',['code'=>$code,'message'=>$message,'clientes'=>$clientes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('layouts.clientes_save');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientesRequest $request)
    {
        try{
            $file    = $request->file('imagen');
            $prefijo = date('YmdHis');
            $archivo = $prefijo.'_'.$file->getClientOriginalName();
            $file->move(public_path().'/images/clientes/',$prefijo.'_'.$file->getClientOriginalName());
            $cliente = new Clientes;
            $cliente->cliente=$request->get('nombre');
            $cliente->descripcion=$request->get('descripcion');
            $cliente->codigo=$request->get('codigo');
            $cliente->estado=1;
            $cliente->imagen=$archivo;
            $cliente->save();
            return redirect('clientes')->with(array('code'=>'200','message'=>'Registrado Creado Correctamente'));
        }catch(\Exception $e){
            return redirect('clientes')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
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
            $cliente  = Clientes::findOrFail($id);
            return view('layouts.clientes_save',['cliente'=>$cliente]); 
        }catch (\ModelNotFoundException $e){   
            return redirect('clientes')->with(array('code'=>401,'message'=>'Cliente no encontrado'));
        }catch(\Exception $e){
            return redirect('clientes')->with(array('code'=>500,'message'=>$e->getCode().' '.$e->getMessage()));
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
    public function update(ClientesRequest $request, $id)
    {
        try{
            $file    = $request->file('imagen');
            $cliente = Clientes::findOrFail($id);
            if($file)
            {
                $prefijo = date('YmdHis');
                $archivo = $prefijo.'_'.$file->getClientOriginalName();
                $file->move(public_path().'/images/clientes/',$prefijo.'_'.$file->getClientOriginalName());
                File::delete(public_path().'/images/clientes/'.$cliente->imagen);
                $cliente->imagen=$archivo; 
            }
            $cliente->cliente=$request->get('nombre');
            $cliente->descripcion=$request->get('descripcion');
            $cliente->codigo=$request->get('codigo');
            $cliente->estado=$request->get('estado');
            $cliente->save();
            return redirect('clientes')->with(array('code'=>'200','message'=>'Registrado Actualizado Correctamente'));
        }catch(\Exception $e){
            return redirect('clientes')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
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
}
