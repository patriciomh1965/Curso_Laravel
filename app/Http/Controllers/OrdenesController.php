<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoriasRequest;
use App\User;
use App\Models\Clientes;
use App\Models\Sucursales;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\UserCliente;
use App\Models\Ordenes;
use App\Models\OrdenesDetalle;
use App\Models\MovProductos;
use App\Models\Estados;
use App\Models\TipoRequerimiento;
use App\Models\Comentarios;
use App\Models\Bitacora;
use ZipArchive;

class OrdenesController extends Controller
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
        $requerimientos=TipoRequerimiento::where('estado',1)->get();
        switch ($user->id_perfil) {
            case env('PERFIL_ADMIN'):
                $clientes=Clientes::where('estado',1)->get();
                break;
            default:
                $usercli=UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
                $clientes=Clientes::where('estado',1)->whereIn('id_cliente',$usercli)->get();
                break;
        }
        return view('layouts.ordenes',['code'=>$code,'message'=>$message,'clientes'=>$clientes,'categorias'=>$categorias,'requerimientos'=>$requerimientos]);
    }
    public function store(Request $request){
       
       $user    = auth()->user();
       $data=$request->get('datos');
       $producto=array();
       $id_cliente=$id_sucursal=$id_user=$observacion='';
       foreach ($data as $key => $value) {
           $id_cliente=$value['id_cliente'];
           $id_sucursal=$value['id_sucursal'];
           $id_user=$value['id_user'];
           $fecha_estimada=$value['fecha_estimada'];
           $observacion=$value['observacion'];
           $requerimiento=$value['requerimiento'];
           $productos=$value['productos'];
       }
       switch ($user->id_perfil) {
            case env('PERFIL_ADMIN'):
            break;
            default:
                $checkclienteusuario  = UserCliente::where('id_cliente',$id_cliente)->where('id_user',$user->id_user)->count();
                $checksucursal = Sucursales::where('id_cliente',$id_cliente)->where('estado',1)->count();
                $checkasignado = UserCliente::where('id_cliente',$id_cliente)->where('id_user',$id_user)->count();
                if($checkclienteusuario == 0 or $checksucursal == 0 or $checkasignado == 0)
                {
                    return array('code'=>'500','message'=>'Error en los datos ingresados'); 
                }
            break;
        }
        if(count($productos) == 0) {  return array('code'=>'401','message'=>'Favor Ingresar Productos'); }
        
        $orden= new Ordenes;
        $orden->id_cliente=$id_cliente;
        $orden->id_sucursal=$id_sucursal;
        $orden->id_user_asignado=$id_user;
        $orden->id_user_creador=$user->id_user;
        $orden->id_estado=4;
        $orden->id_tipo_requerimiento=$requerimiento;
        $orden->fecha_estimada=$fecha_estimada;
        $orden->observacion=$observacion;
        $orden->totalvalor=0;
        $orden->totalproductos=0;
        $orden->save();
        $idorden=$orden->id_orden;
        $totalprod=$valororden=0;
        foreach ($productos as $key) {
          $id=$key['id'];
          $cantidad=$key['cantidad'];
          $getproducto = Productos::where('id_producto',$id)->first();
          $precio=$getproducto->precio; 
          $ordendetalle = new OrdenesDetalle ;
          $ordendetalle->id_orden = $idorden;
          $ordendetalle->id_producto=$id;
          $ordendetalle->id_cliente=$id_cliente;
          $ordendetalle->cantidad=$cantidad;
          $ordendetalle->valor_unitario=$precio;
          $ordendetalle->valor_total=$precio*$cantidad;
          $ordendetalle->id_estado=1;
          $ordendetalle->save();

          $movproducto = new MovProductos ;
          $movproducto->codigo_ingreso=$orden->id_orden;
          $movproducto->id_producto=$key['id'];
          $movproducto->cantidad='-'.$key['cantidad'];
          $movproducto->fecha_ingreso=$fecha_estimada;
          $movproducto->tipo='ORDEN PRODUCTO';
          $movproducto->precio=$precio;
          $movproducto->id_user_responsable= $user->id_user;
          $movproducto->save();

          $totalprod++;
          $valororden += $precio*$cantidad;
        }
        $orden->totalvalor=$valororden;
        $orden->totalproductos=$totalprod;
        $orden->save();

        $bitacora = new Bitacora;
        $bitacora->id_orden=$orden->id_orden;
        $bitacora->id_usuario=$user->id_user;
        $bitacora->id_estado=4;
        $bitacora->id_comentario=10;
        $bitacora->observacion=$observacion;
        $bitacora->save();

        return array('code'=>'200','message'=>'Orden Generada con Exito');
    }


    public function getordenedetalle($id)
    {   
        $user    = auth()->user();
        switch ($user->id_perfil) {
            case env('PERFIL_ADMIN'):
                return OrdenesDetalle::select('producto','sys_09_categorias.nombre as categoria','id_orden','cantidad','valor_unitario','valor_total')->where('id_orden',$id)->leftJoin('sys_10_producto', 'sys_13_ordenes_detalle.id_producto', '=', 'sys_10_producto.id_producto')->leftJoin('sys_09_categorias', 'sys_09_categorias.id_categoria', '=', 'sys_10_producto.id_categoria')->get();
                break;
            default:
                $usercli=UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
                $checkorden=Ordenes::where('id_orden',$id)->whereIn('id_cliente',$usercli)->count();
                if($checkorden > 0)
                {
                    return OrdenesDetalle::select('producto','sys_09_categorias.nombre as categoria','id_orden','cantidad','valor_unitario','valor_total')->where('id_orden',$id)->leftJoin('sys_10_producto', 'sys_13_ordenes_detalle.id_producto', '=', 'sys_10_producto.id_producto')->leftJoin('sys_09_categorias', 'sys_09_categorias.id_categoria', '=', 'sys_10_producto.id_categoria')->get();
                }
                break;
        }  
    }

    public function edit($id)
    {   
        try{
            $user    = auth()->user();
            $requerimientos = TipoRequerimiento::get();
            $categorias=Categorias::where('estado',1)->get();
            $ordenes=Ordenes::findOrFail($id);
            if($ordenes->id_estado==5 or $ordenes->id_estado==6  )
            {
              return redirect('ordenes/list')->with(array('code'=>'500','message'=>'orden invalida'));
            }
            $sucursales=Sucursales::where('id_cliente',$ordenes->id_cliente)->get();
            $ordenesdetalle=OrdenesDetalle::where('id_orden',$id)->get();
            $usarioscliente=User::select('id_user','name','email')->where('estado',1)->whereIn('id_perfil',[env('PERFIL_BODEGA'),env('PERFIL_ADMIN')])->get();           
            return view('layouts.ordenes_edit',['categorias'=>$categorias,'ordenes'=>$ordenes,'ordenesdetalle'=>$ordenesdetalle,'sucursales'=>$sucursales,'usarioscliente'=>$usarioscliente,'requerimientos'=>$requerimientos]); 
        }catch(\Exception $e){
            return redirect('ordenes/list')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
        }
    }
    public function update_orden(Request $request, $id){
      try{
        $user    = auth()->user();
        $data=$request->get('datos');
        $producto=array();
        $id_orden=$id_sucursal=$id_user=$observacion='';
        foreach ($data as $key => $value) {
            $id_orden=$value['id_orden'];
            $id_sucursal=$value['id_sucursal'];
            $id_user=$value['id_user'];
            $fecha_estimada=$value['fecha_estimada'];
            $observacion=$value['observacion'];
            $requerimiento=$value['requerimiento'];
            $productos=$value['productos'];
        }
        if(count($productos) == 0) {  return array('code'=>'401','message'=>'Favor Ingresar Productos'); }
        $orden= Ordenes::findOrFail($id_orden);
        if($orden->id_estado==1 or $orden->id_estado == 5 or $orden->id_estado == 6) {  return array('code'=>'401','message'=>'La orden se encuentra autorizada o cerrada no puede editarla'); }
        $orden->id_sucursal=$id_sucursal;
        $orden->id_user_asignado=$id_user;
        $orden->id_user_creador=$user->id_user;
        $orden->id_tipo_requerimiento=$requerimiento;
        $orden->fecha_estimada=$fecha_estimada;
        $orden->observacion=$observacion;
        $orden->save();
        $id_cliente=$orden->id_cliente;
        $totalprod=$valororden=0;
        OrdenesDetalle::where('id_orden',$id_orden)->delete(); 
        MovProductos::where('codigo_ingreso',$id_orden)->where('tipo','ORDEN PRODUCTO')->delete();   
        foreach ($productos as $key) {
            $id=$key['id'];
            $cantidad=$key['cantidad'];       
            $getproducto = Productos::where('id_producto',$id)->first();
            $precio=$getproducto->precio; 
            $ordendetalle = new OrdenesDetalle;
            $ordendetalle->id_orden = $id_orden;
            $ordendetalle->id_producto=$id;
            $ordendetalle->id_cliente=$id_cliente;
            $ordendetalle->cantidad=$cantidad;
            $ordendetalle->valor_unitario=$precio;
            $ordendetalle->valor_total=$precio*$cantidad;
            $ordendetalle->id_estado=1;
            $ordendetalle->save();
            
            $movproducto = new MovProductos ;
            $movproducto->codigo_ingreso=$id_orden;
            $movproducto->id_producto=$key['id'];
            $movproducto->cantidad='-'.$key['cantidad'];
            $movproducto->fecha_ingreso=$fecha_estimada;
            $movproducto->tipo='ORDEN PRODUCTO';
            $movproducto->precio=$precio;
            $movproducto->id_user_responsable= $user->id_user;
            $movproducto->save();
            $totalprod++;
            $valororden += $precio*$cantidad;
        }
        $orden->totalvalor=$valororden;
        $orden->totalproductos=$totalprod;
        $orden->save();
        return array('code'=>'200','message'=>'Orden actualizada con exito');
      }catch(\Exception $e){
          return array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage());
      }
    }
    public function getordenes(Request $request)
    {  
        $code=$request->session()->get('code');
        $message=$request->session()->get('message');
        $user    = auth()->user();
        $ordenes=Ordenes::get();
        return view('layouts.cliente_ordenes',['code'=>$code,'message'=>$message,'ordenes'=>$ordenes]);
    }
    public function getactualizar($id){
      $orden = Ordenes::findOrFail($id);
      if($orden->id_estado == 5 or $orden->id_estado == 6){
        return redirect('ordenes/list')->with(array('code'=>'500','message'=>'La orden ya fue finalizada o cancelada'));
      }
      $estados = Estados::get();
      $comentarios = Comentarios::where('estado',1)->get();
      return view('layouts.cliente_ordenes_actualizar',['comentarios'=>$comentarios,'orden'=>$orden,'estados'=>$estados]);
    }
    public function actualizar(Request $request){
      try{
        $user    = auth()->user();
        $getorden = Ordenes::findOrFail($request->get('id_orden'));
        if($getorden->id_estado == 5 or $getorden->id_estado == 6){
          return redirect('ordenes/list')->with(array('code'=>'500','message'=>'La orden ya fue finalizada o cancelada'));
        }
        $getcomentario=Comentarios::findOrFail($request->get('comentario'));
        $otros='';
        if($getcomentario->id_comentario==10)
        {
          $otros=$request->get('observacion');
        }
        $bitacora = new Bitacora;
        $bitacora->id_orden=$getorden->id_orden;
        $bitacora->id_usuario=$user->id_user;
        $bitacora->id_estado=$request->get('estado');
        $bitacora->id_comentario=$request->get('comentario');
        $bitacora->observacion=$otros;
        $bitacora->save();
        if($request->hasfile('archivos'))
        {
          $nuevo_archivo=date('YmdHis').'_'.$bitacora->id_bitacora.'.zip';
          $bitacora->archivo=$nuevo_archivo;
          $bitacora->save();
          $files = $request->file('archivos');
          $zip=new ZipArchive();
          $newzip=storage_path()."/app/ordenes_detalle/".$nuevo_archivo;
          if($zip->open($newzip,ZIPARCHIVE::CREATE)===true) {
            foreach($files as $file){
              $filename = $file->getClientOriginalName(); 
              $zip->addFile($file,$filename);  
            }
            $zip->close();
          }
        }
        $getorden->id_estado=$request->get('estado');
        $getorden->save();
        return redirect('ordenes/list')->with(array('code'=>'200','message'=>'Orden actualizada con exito'));
      }catch(\Exception $e){
        return redirect('ordenes/list')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
      }
    }
    public function getarchivos($id){
      $user    = auth()->user();
      $bitacora=Bitacora::findOrFail($id);
      return response()->download(storage_path()."/app/ordenes_detalle/".$bitacora->archivo); 
    }
    public function getorden($id){
      $user    = auth()->user();
      switch ($user->id_perfil) {
        case env('PERFIL_ADMIN'):
        case env('PERFIL_BODEGA'):
            $ordenes=Ordenes::findOrFail($id);
            $ordenesdetalle=OrdenesDetalle::where('id_orden',$id)->get();
            $bitacoras=Bitacora::where('id_orden',$id)->get();
            return view('layouts.ordenes_show',['ordenes'=>$ordenes,'ordenesdetalle'=>$ordenesdetalle,'bitacoras'=>$bitacoras]);
        break;
        default:
            $usercli=UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
            $ordenes=Ordenes::whereIn('id_cliente',$usercli)->where('id_orden',$id)->first();
            if($ordenes)
            {
              $ordenesdetalle=OrdenesDetalle::where('id_orden',$id)->get();
              $bitacoras=Bitacora::where('id_orden',$id)->get();
              return view('layouts.ordenes_show',['ordenes'=>$ordenes,'ordenesdetalle'=>$ordenesdetalle,'bitacoras'=>$bitacoras]);
            }else{
              return redirect('ordenes/list')->with(array('code'=>'500','message'=>'Orden no valida'));
            }
        break;
      }
    }
    public function tracking($id){
      $bitacoras=Bitacora::where('id_orden',$id)->get();
      return view('layouts.ordenes_tracking',['bitacoras'=>$bitacoras]);
    }
    public function sucursales($id){
      return Sucursales::where('id_cliente',$id)->where('estado',1)->orderBy('nombre')->get();
    }
    public function productos($id){
      return Productos::where('id_categoria',$id)->where('estado',1)->orderBy('producto')->get();
    }
    public function usuarios($id){
      return User::select('id_user','name','email')->where('estado',1)->whereIn('id_perfil',[env('PERFIL_BODEGA'),env('PERFIL_ADMIN')])->get();
    }
    public function getproducto($id){
      return Productos::select('sys_10_producto.id_producto','sys_10_producto.codigo','producto','sys_09_categorias.nombre as categoria','sys_10_producto.descripcion','precio')->leftJoin('sys_09_categorias', 'sys_09_categorias.id_categoria', '=', 'sys_10_producto.id_categoria')->where('id_producto',$id)->where('sys_10_producto.estado',1)->get();
    }
}
