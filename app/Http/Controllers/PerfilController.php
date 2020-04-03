<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PerfilRequest;
use App\Models\Perfil;

class PerfilController extends Controller
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
        $perfiles=Perfil::all();
        $code=$request->session()->get('code');
        $message=$request->session()->get('message');
        return view('layouts.perfil',['code'=>$code,'message'=>$message,'perfiles'=>$perfiles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.perfil_save');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerfilRequest $request)
    {
        try{
            $perfil = new Perfil;
            $perfil->perfil=$request->get('perfil');
            $perfil->estado='1';
            $perfil->save();
            return redirect('perfiles')->with(array('code'=>'200','message'=>'Registrado Creado Correctamente'));
        }catch(\Exception $e){
            return redirect('perfiles')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
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
            $perfil = Perfil::findOrFail($id);
            return view('layouts.perfil_save',['perfil'=>$perfil]); 
        }catch (\ModelNotFoundException $e){   
            return redirect('perfiles')->with(array('code'=>401,'message'=>'Perfil no encontrado'));
        }catch(\Exception $e){
            return redirect('perfiles')->with(array('code'=>500,'message'=>$e->getCode().' '.$e->getMessage()));
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
    public function update(PerfilRequest $request, $id)
    {
        try{
            $perfil = Perfil::findOrFail($id);
            $perfil->perfil=$request->get('perfil');
            $perfil->estado=$request->get('estado');
            $perfil->save();
            return redirect('perfiles')->with(array('code'=>'200','message'=>'Registrado Actualizado Correctamente'));
        }catch(\Exception $e){
            return redirect('perfiles')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
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
