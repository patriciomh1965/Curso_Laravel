<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductosRequest;
use App\Models\Productos;
use App\Models\Categorias;
use App\Models\MovProductos;
use File;

class ProductosController extends Controller
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
        $productos=Productos::all();
        $code=$request->session()->get('code');
        $message=$request->session()->get('message');
        return view('layouts.productos',['code'=>$code,'message'=>$message,'productos'=>$productos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categorias=Categorias::where('estado',1)->get();
        return view('layouts.productos_save',['categorias'=>$categorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductosRequest $request)
    {
        try{
            $file    = $request->file('imagen');
            $prefijo = date('YmdHis');
            $archivo = $prefijo.'_'.$file->getClientOriginalName();
            $file->move(public_path().'/images/productos/',$prefijo.'_'.$file->getClientOriginalName());
            $producto = new Productos;
            $producto->producto=$request->get('producto');
            $producto->descripcion=$request->get('descripcion');
            $producto->codigo=$request->get('codigo');
            $producto->min_stock=$request->get('minstock');
            $producto->precio=$request->get('precio');
            $producto->id_categoria=$request->get('categoria');
            $producto->imagen=$archivo;
            $producto->estado=1;
            $producto->save();
            return redirect('productos')->with(array('code'=>'200','message'=>'Registrado Creado Correctamente'));
        }catch(\Exception $e){
            return redirect('productos')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
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
            $producto  = Productos::findOrFail($id);
            $categorias= Categorias::get();
            return view('layouts.productos_save',['producto'=>$producto,'categorias'=>$categorias]); 
        }catch (\ModelNotFoundException $e){   
            return redirect('productos')->with(array('code'=>401,'message'=>'Categoria no encontrado'));
        }catch(\Exception $e){
            return redirect('productos')->with(array('code'=>500,'message'=>$e->getCode().' '.$e->getMessage()));
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
    public function update(ProductosRequest $request, $id)
    {
        try{
            $file    = $request->file('imagen');
            $producto = Productos::findOrFail($id);
            if($file)
            {
                $prefijo = date('YmdHis');
                $archivo = $prefijo.'_'.$file->getClientOriginalName();
                $file->move(public_path().'/images/productos/',$prefijo.'_'.$file->getClientOriginalName());
                @File::delete(public_path().'/images/productos/'.$cliente->imagen);
                $producto->imagen=$archivo; 
            }
            $producto->producto=$request->get('producto');
            $producto->descripcion=$request->get('descripcion');
            $producto->codigo=$request->get('codigo');
            $producto->min_stock=$request->get('minstock');
            $producto->id_categoria=$request->get('categoria');
            $producto->precio=$request->get('precio');
            $producto->estado=$request->get('estado');
            $producto->save();
            return redirect('productos')->with(array('code'=>'200','message'=>'Registrado Actualizado Correctamente'));
        }catch(\Exception $e){
            return redirect('productos')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
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

    public function getmovimiento($id){
        $data = MovProductos::where('id_producto',$id)->get();
        return view('layouts.productos_mov',['data'=>$data]);
    }
}
