<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoriasRequest;
use App\Models\Clientes;
use App\User;
use App\Models\Sucursales;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\UserCliente;
use App\Models\Ordenes;
use App\Models\OrdenesDetalle;


class GetOrdenesController extends Controller
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
        switch ($user->id_perfil) {
            case env('PERFIL_ADMIN'):
                $ordenes=Ordenes::get();
                break;
            default:
                $usercli=UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
                $ordenes=Ordenes::whereIn('id_cliente',$usercli)->get();
                break;
        }
        return view('layouts.cliente_ordenes',['code'=>$code,'message'=>$message,'ordenes'=>$ordenes]);
    }

    public function show($id)
    {   
        $user    = auth()->user();
        switch ($user->id_perfil) {
            case env('PERFIL_ADMIN'):
                return OrdenesDetalle::where('id_orden',$id)->get();
                break;
            default:

                $usercli=UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
                $checkorden=Ordenes::where('id_orden',$id)->whereIn('id_cliente',$usercli)->count();
                if($checkorden > 0)
                {
                    return OrdenesDetalle::select('producto','id_orden','cantidad','valor_unitario','valor_total')->where('id_orden',$id)->leftJoin('sys_10_producto', 'sys_13_ordenes_detalle.id_producto', '=', 'sys_10_producto.id_producto')->get();
                }
                break;
        }  
    }
}
