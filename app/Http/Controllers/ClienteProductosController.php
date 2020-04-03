<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductosRequest;
use App\Models\Productos;
use App\Models\UserCliente;
use App\Models\OrdenesDetalle;

class ClienteProductosController extends Controller
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
        
        $code=$request->session()->get('code');
        $message=$request->session()->get('message');
        $user    = auth()->user();
        $usercli=UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
        $getproductos=OrdenesDetalle::select('id_producto')->whereIn('id_cliente',$usercli)->groupBy('id_producto')->get();
        return view('layouts.cliente_productos',['code'=>$code,'message'=>$message,'getproductos'=>$getproductos]);
    }

  
    public function show($id)
    {
        $user    = auth()->user();
        $usercli=UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
        $getdetalleproductos=OrdenesDetalle::whereIn('id_cliente',$usercli)->where('id_producto',$id)->orderBy('id_orden')->get();
        return view('layouts.cliente_productos_ordenes',['getdetalleproductos'=>$getdetalleproductos]);
    }

   
}
