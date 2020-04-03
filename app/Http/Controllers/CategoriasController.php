<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoriasRequest;
use App\Models\Categorias;

class CategoriasController extends Controller
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
        $categorias=Categorias::all();
        $code=$request->session()->get('code');
        $message=$request->session()->get('message');
        return view('layouts.categorias',['code'=>$code,'message'=>$message,'categorias'=>$categorias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('layouts.categorias_save');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriasRequest $request)
    {
        try{
            $categoria = new Categorias;
            $categoria->nombre=$request->get('categoria');
            $categoria->descripcion=$request->get('descripcion');
            $categoria->codigo=$request->get('codigo');
            $categoria->estado=1;
            $categoria->save();
            return redirect('categorias')->with(array('code'=>'200','message'=>'Registrado Creado Correctamente'));
        }catch(\Exception $e){
            return redirect('categorias')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
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
            $categoria  = Categorias::findOrFail($id);
            return view('layouts.categorias_save',['categoria'=>$categoria]); 
        }catch (\ModelNotFoundException $e){   
            return redirect('categorias')->with(array('code'=>401,'message'=>'Categoria no encontrado'));
        }catch(\Exception $e){
            return redirect('categorias')->with(array('code'=>500,'message'=>$e->getCode().' '.$e->getMessage()));
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
    public function update(CategoriasRequest $request, $id)
    {
        try{
            $categoria = Categorias::findOrFail($id);
            $categoria->nombre=$request->get('categoria');
            $categoria->descripcion=$request->get('descripcion');
            $categoria->codigo=$request->get('codigo');
            $categoria->estado=$request->get('estado');
            $categoria->save();
            return redirect('categorias')->with(array('code'=>'200','message'=>'Registrado Actualizado Correctamente'));
        }catch(\Exception $e){
            return redirect('categorias')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
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
