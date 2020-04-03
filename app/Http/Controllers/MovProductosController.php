<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\MovProductos;
use Validator;

class MovProductosController extends Controller
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
      $categorias=Categorias::where('estado',1)->get();
      return view('layouts.mov_productos',['code'=>$code,'message'=>$message,'categorias'=>$categorias]);
    }
    public function store(Request $request){
       
      $user    = auth()->user();
      $data=$request->get('datos');
      $producto=array();
      foreach ($data as $key => $value) {
        $productos=$value['productos'];
      }
      if(count($productos) == 0) {  return array('code'=>'401','message'=>'Favor Ingresar Productos'); }
      $errores='';
      foreach ($productos as $key) {
        $checkdata=array('id_producto'=>$key['id'],'codigo_ingreso'=>$key['codigo_ingreso'],'cantidad'=>$key['cantidad'],'fecha'=>$key['fecha']);
        $validator = Validator::make($checkdata, [
          'id_producto'  => 'required|exists:sys_10_producto,id_producto',
          'codigo_ingreso' => 'required|min:1|max:50',
          'cantidad' => 'required|numeric|min:1',
          'fecha' => 'required|date',
        ]);        
        if ($validator->fails()) 
        {     
          $datos   = $validator->errors()->messages();
          foreach ($datos as $key => $value) {          
            $errores .= 'Error:'.$value[0].'<\br>';
          }
          return array('code'=>'500','message'=>$errores);
        }  
      }
      foreach ($productos as $key) {
        $getproducto = Productos::where('id_producto',$key['id'])->first();
        $precio=$getproducto->precio; 
        $movproducto = new MovProductos ;
        $movproducto->codigo_ingreso=$key['codigo_ingreso'];
        $movproducto->id_producto=$key['id'];
        $movproducto->cantidad=$key['cantidad'];
        $movproducto->fecha_ingreso=$key['fecha'];
        $movproducto->tipo='INGRESO PRODUCTO';
        $movproducto->precio=$precio;
        $movproducto->id_user_responsable= $user->id_user;
        $movproducto->save();
      }
      return array('code'=>'200','message'=>'Ingreso Productos Generado con Exito');
    }
    public function productos($id){
        return Productos::where('id_categoria',$id)->where('estado',1)->get();;
    }
    public function getproducto($id){
        return Productos::select('sys_10_producto.id_producto','sys_10_producto.codigo','producto','sys_09_categorias.nombre as categoria','sys_10_producto.descripcion','precio')->leftJoin('sys_09_categorias', 'sys_09_categorias.id_categoria', '=', 'sys_10_producto.id_categoria')->where('id_producto',$id)->where('sys_10_producto.estado',1)->get();
    }
}
