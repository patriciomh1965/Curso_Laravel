<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoriasRequest;
use App\Http\Requests\PresupuestoActualizarRequest;
use App\Models\Clientes;
use App\User;
use App\Models\Sucursales;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\UserCliente;
use App\Models\Presupuesto;
use App\Models\PresupuestoDetalle;
use App\Models\MovProductos;
use App\Models\TipoRequerimiento;
use App\Models\Estados;
use App\Models\Ordenes;
use App\Models\OrdenesDetalle;
use App\Models\Bitacora;
use ZipArchive;
use Mail;
use Storage;

class ClientePresupuestosController extends Controller
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
            case env('PERFIL_ORDEN'):
              $presupuestos=Presupuesto::get();
            break;
            case env('PERFIL_CLIENTE'):
              $usercli=UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
              $presupuestos=Presupuesto::whereIn('id_cliente',$usercli)->get();
            break;
        }        
        return view('layouts.cliente_presupuestos',['code'=>$code,'message'=>$message,'presupuestos'=>$presupuestos]);
    }

    public function create(){
      $user    = auth()->user();
      $categorias=Categorias::where('estado',1)->get();
      $requerimientos=TipoRequerimiento::where('id_tipo_requerimiento','<>',9)->where('estado',1)->get();
      switch ($user->id_perfil) {
          case env('PERFIL_ADMIN'):
          case env('PERFIL_ORDEN'):
              $clientes=Clientes::where('estado',1)->get();
          break;
          case env('PERFIL_CLIENTE'):
              $usercli=UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
              $clientes=Clientes::where('estado',1)->whereIn('id_cliente',$usercli)->get();
          break;
      }
      //tipo 9 campaña 
      return view('layouts.cliente_presupuestos_create',['categorias'=>$categorias,'clientes'=>$clientes,'requerimientos'=>$requerimientos]);
    }

    public function show($id){
      $user    = auth()->user();
       switch ($user->id_perfil) {
            case env('PERFIL_ADMIN'):
            case env('PERFIL_ORDEN'):
              $presupuesto=Presupuesto::where('id_presupuesto',$id)->first();
              if($presupuesto)
              {
                $presupuestodetalle = PresupuestoDetalle::where('id_presupuesto',$id)->get();
                $bitacoras=Bitacora::where('id_presupuesto',$id)->get();
                return view('layouts.cliente_presupuestos_show',['presupuesto'=>$presupuesto,'presupuestodetalle'=>$presupuestodetalle,'bitacoras'=>$bitacoras]);
              }
              return view('layouts.cliente_presupuestos_show',['presupuesto'=>$presupuesto]);
            break;
            case env('PERFIL_CLIENTE'):
              $usercli=UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
              $presupuesto=Presupuesto::where('id_presupuesto',$id)->whereIn('id_cliente',$usercli)->first();
              if($presupuesto)
              {
                $presupuestodetalle = PresupuestoDetalle::where('id_presupuesto',$id)->get();
                $bitacoras=Bitacora::where('id_presupuesto',$id)->get();
                return view('layouts.cliente_presupuestos_show',['presupuesto'=>$presupuesto,'presupuestodetalle'=>$presupuestodetalle,'bitacoras'=>$bitacoras]);
              }
            break;
      }
      return view('layouts.cliente_presupuestos_show');
    }
    public function store(Request $request){
       $user    = auth()->user();
       $data=$request->get('datos');
       $producto=array();
       $id_cliente=$id_sucursal=$observacion=$fechasolicitud=$solicitante=$requerimiento=$npresupuesto='';
       foreach ($data as $key => $value) {
           $id_cliente=$value['id_cliente'];
           $id_sucursal=$value['id_sucursal'];
           $observacion=$value['observacion'];
           $productos=$value['productos'];
           $fechasolicitud=$value['fecha_solicitud'];
           $solicitante=$value['solicitante'];
           $requerimiento=$value['requerimiento'];
           $npresupuesto=$value['npresupuesto'];
       }
       switch ($user->id_perfil) {
            case env('PERFIL_ADMIN'):
            case env('PERFIL_ORDEN'):
            break;
            default:
                $checkclienteusuario  = UserCliente::where('id_cliente',$id_cliente)->where('id_user',$user->id_user)->count();
                $checksucursal = Sucursales::where('id_cliente',$id_cliente)->where('estado',1)->count();
                if($checkclienteusuario == 0 or $checksucursal == 0)
                {
                    return array('code'=>'500','message'=>'Error en los datos ingresados'); 
                }
            break;
        }
        if(count($productos) == 0) {  return array('code'=>'401','message'=>'Favor Ingresar Productos'); }
        $presupuesto= new Presupuesto;
        $presupuesto->id_cliente=$id_cliente;
        $presupuesto->id_sucursal=$id_sucursal;
        $presupuesto->id_user=$user->id_user;
        $presupuesto->id_estado=4;
        $presupuesto->id_tipo_requerimiento=$requerimiento;
        $presupuesto->observacion=$observacion;
        $presupuesto->fecha_solicitud=$fechasolicitud;
        $presupuesto->solicitante=$solicitante;
        $presupuesto->npresupuesto=$npresupuesto;
        $presupuesto->totalvalor=0;
        $presupuesto->totalproductos=0;
        $presupuesto->save();
        $idpresupuesto=$presupuesto->id_presupuesto;
        $totalprod=$valororden=0;
        foreach ($productos as $key) {
          $id=$key['id'];
          $cantidad=$key['cantidad'];
          $getproducto = Productos::where('id_producto',$id)->first();
          $precio=$getproducto->precio; 
          $presupuestodetalle = new PresupuestoDetalle ;
          $presupuestodetalle->id_presupuesto = $idpresupuesto;
          $presupuestodetalle->id_producto=$id;
          $presupuestodetalle->cantidad=$cantidad;
          $presupuestodetalle->valor_unitario=$precio;
          $presupuestodetalle->valor_total=$precio*$cantidad;
          $presupuestodetalle->save();
          $totalprod++;
        }
        $presupuesto->totalvalor=$valororden;
        $presupuesto->totalproductos=$totalprod;
        $presupuesto->save();

        $bitacora = new Bitacora;
        $bitacora->id_orden=0;
        $bitacora->id_presupuesto=$idpresupuesto;
        $bitacora->id_usuario=$user->id_user;
        $bitacora->id_estado=4;
        $bitacora->id_comentario=10;
        $bitacora->observacion=$observacion;
        $bitacora->save();
        /*Mail::send('mail.presupuesto', ['datos' => $presupuesto], function($message)
        {
            $message->to(env('MAIL_NOTIFICACION'))->subject('Nuevo Presupuesto.');
        });*/
        return array('code'=>'200','message'=>'Presupuesto Generado con Exito');
    }

    public function edit($id)
    {   
        try{
            $user    = auth()->user();
            $estados = Estados::whereIn('id_estado',[1,4,7,5,6])->get();
            //tipo 9 campaña
            $requerimientos=TipoRequerimiento::where('id_tipo_requerimiento','<>',9)->where('estado',1)->get();
            $categorias=Categorias::where('estado',1)->get();
            switch ($user->id_perfil) {
                case env('PERFIL_ADMIN'):
                case env('PERFIL_ORDEN'):
                    $presupuesto=Presupuesto::where('id_presupuesto',$id)->first();
                    if($presupuesto->id_estado==5 or $presupuesto->id_estado==6)
                    {
                      return redirect('clientepresupuesto')->with(array('code'=>'500','message'=>'orden invalida'));
                    }
                    $presupuestodetalle=PresupuestoDetalle::where('id_presupuesto',$id)->get();
                    $sucursales=Sucursales::where('id_cliente',$presupuesto->id_cliente)->get();
                    break;
                default:
                    return redirect('clientepresupuesto')->with(array('code'=>'500','message'=>'No valida esta opción'));
                break;
            }
            return view('layouts.cliente_presupuestos_edit',['categorias'=>$categorias,'presupuesto'=>$presupuesto,'presupuestodetalle'=>$presupuestodetalle,'sucursales'=>$sucursales,'estados'=>$estados,'requerimientos'=>$requerimientos]); 
        }catch(\Exception $e){
            return redirect('clientepresupuesto')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
        }
    }

    public function update_presupuesto(Request $request, $id){

       $user    = auth()->user();
       $data=$request->get('datos');
       $producto=array();
       $id_sucursal=$observacion=$fechasolicitud=$solicitante=$requerimiento=$npresupuesto='';
       foreach ($data as $key => $value) {
           $id_sucursal=$value['id_sucursal'];
           $observacion=$value['observacion'];
           $productos=$value['productos'];
           $fechasolicitud=$value['fecha_solicitud'];
           $solicitante=$value['solicitante'];
           $requerimiento=$value['requerimiento'];
           $npresupuesto=$value['npresupuesto'];
       }
       switch ($user->id_perfil) {
            case env('PERFIL_ADMIN'):
            case env('PERFIL_ORDEN'):
            break;
            default:
                return array('code'=>'500','message'=>'No disponible esta función'); 
            break;
        }
        if(count($productos) == 0) {  return array('code'=>'401','message'=>'Favor Ingresar Productos'); }        
        $presupuesto= Presupuesto::findOrFail($id);
        $presupuesto->id_sucursal=$id_sucursal;
        $presupuesto->id_user=$user->id_user;
        $presupuesto->id_estado=4;
        $presupuesto->id_tipo_requerimiento=$requerimiento;
        $presupuesto->observacion=$observacion;
        $presupuesto->fecha_solicitud=$fechasolicitud;
        $presupuesto->solicitante=$solicitante;
        $presupuesto->npresupuesto=$npresupuesto;
        $presupuesto->save();   
        $totalprod=$valororden=0;
        PresupuestoDetalle::where('id_presupuesto',$id)->delete();
        foreach ($productos as $key) {
          $idjson=$key['id'];
          $cantidad=$key['cantidad'];
          $getproducto = Productos::where('id_producto',$idjson)->first();
          $precio=$getproducto->precio; 
          $presupuestodetalle = new PresupuestoDetalle ;
          $presupuestodetalle->id_presupuesto = $id;
          $presupuestodetalle->id_producto=$getproducto->id_producto;
          $presupuestodetalle->cantidad=$cantidad;
          $presupuestodetalle->valor_unitario=$precio;
          $presupuestodetalle->valor_total=$precio*$cantidad;
          $presupuestodetalle->save();
          $totalprod++;
        }
        $presupuesto->totalvalor=$valororden;
        $presupuesto->totalproductos=$totalprod;
        $presupuesto->save();
        return array('code'=>'200','message'=>'Presupuesto Actualizado con Exito');
    }

    public function actualizar($id){
      $user    = auth()->user();
      switch ($user->id_perfil) {
            case env('PERFIL_ADMIN'):
            case env('PERFIL_ORDEN'):
                $presupuesto= Presupuesto::findOrFail($id);
                $estados = Estados::whereIn('id_estado',[1,4,7,5,6])->get();
                return view('layouts.cliente_presupuestos_actualizar',['presupuesto'=>$presupuesto,'estados'=>$estados]);
            break;
            default:
                redirect('clientepresupuesto');
            break;
        }
    }
    public function actualizar_estado(PresupuestoActualizarRequest $request){
      try{  
        $user    = auth()->user();
        switch ($user->id_perfil) {
            case env('PERFIL_ADMIN'):
            case env('PERFIL_ORDEN'):
                $presupuesto= Presupuesto::findOrFail($request->get('id_presupuesto'));
                $bitacora = new Bitacora;
                $bitacora->id_orden=0;
                $bitacora->id_presupuesto=$request->get('id_presupuesto');
                $bitacora->id_usuario=$user->id_user;
                $bitacora->id_estado=$request->get('estado');
                $bitacora->id_comentario=10;
                $bitacora->observacion='';
                $bitacora->save();
                if($request->hasfile('archivos'))
                {
                  $nuevo_archivo=date('YmdHis').'_'.$bitacora->id_bitacora.'.zip';
                  $bitacora->archivo=$nuevo_archivo;
                  $bitacora->save();

                  $files = $request->file('archivos');
                  $newzip=storage_path()."/app/presupuestos/".$nuevo_archivo;
                  $zip=new ZipArchive();
                  if($zip->open($newzip,ZIPARCHIVE::CREATE)===true) {
                    foreach($files as $file){
                      $filename = $file->getClientOriginalName(); 
                      $zip->addFile($file,$filename);  
                    }
                    $zip->close();
                  }
                }
                if($request->get('estado')==1){
                  $presupuesto->id_user_autorizado=$user->id_user;
                }
                $presupuesto->totalvalor=$request->get('valor');
                $presupuesto->id_estado=$request->get('estado');
                $presupuesto->save();
                return redirect('clientepresupuesto')->with(array('code'=>'200','message'=>'Actualizado con exito'));
            break;
            default:
                return redirect('clientepresupuesto')->with(array('code'=>'500','message'=>'Opcion no válida'));
            break;
        }
      }catch(\Exception $e){
        return redirect('clientepresupuesto')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
      }
    }
    public function cliente_autorizar(Request $request){
      $user = auth()->user();
      $usercli=UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
      $presupuesto = $request->get('id_presupuesto_autorizar');
      $checkpresupuest=Presupuesto::where('id_presupuesto',$presupuesto)->whereIn('id_cliente',$usercli)->where('id_estado',1)->count();
      if($checkpresupuest > 0)
      {
        $presupuesto=Presupuesto::findOrFail($presupuesto);
        $orden = new Ordenes;
        $orden->id_presupuesto=$presupuesto->id_presupuesto;
        $orden->id_cliente=$presupuesto->id_cliente;
        $orden->id_sucursal=$presupuesto->id_sucursal;
        $orden->id_user_creador=$user->id_user;
        $orden->id_user_asignado=$presupuesto->id_user_autorizado;
        $orden->id_tipo_requerimiento=$presupuesto->id_tipo_requerimiento;
        $orden->npresupuesto=$presupuesto->npresupuesto;
        $orden->id_estado=4;   

        $orden->solicitante=$presupuesto->solicitante;
        $orden->observacion='';
        $orden->observacion_cliente=$presupuesto->observacion;
        $orden->totalvalor=$presupuesto->totalvalor;
        $orden->totalproductos=$presupuesto->totalproductos;
        $orden->fecha_estimada=$presupuesto->fecha_solicitud;
        $orden->save();
        $idorden=$orden->id_orden;
        $idcliente=$presupuesto->id_cliente;
        $presupuestodetalle = PresupuestoDetalle::where('id_presupuesto',$presupuesto->id_presupuesto)->get();
        foreach ($presupuestodetalle as $data) {
          $ordendetalle = new OrdenesDetalle;
          $ordendetalle->id_orden=$idorden;
          $ordendetalle->id_producto=$data->id_producto;
          $ordendetalle->id_cliente=$idcliente;
          $ordendetalle->cantidad=$data->cantidad;
          $ordendetalle->valor_unitario=$data->valor_unitario;
          $ordendetalle->valor_total=$data->valor_total;
          $ordendetalle->id_estado=6;
          $ordendetalle->save();

          $movproducto = new MovProductos ;
          $movproducto->codigo_ingreso=$idorden;
          $movproducto->id_producto=$data->id_producto;
          $movproducto->cantidad=$data->cantidad;
          $movproducto->fecha_ingreso=date('Y-m-d H:i:s');
          $movproducto->tipo='ORDEN PRODUCTO';
          $movproducto->precio=$ordendetalle->Productos->precio;
          $movproducto->id_user_responsable= $user->id_user;
          $movproducto->save();
        }
        $presupuesto->id_estado=6;
        $presupuesto->save();

        $bitacora = new Bitacora;
        $bitacora->id_orden=$idorden;
        $bitacora->id_usuario=$user->id_user;
        $bitacora->id_estado=4;
        $bitacora->id_comentario=10;
        $bitacora->observacion=$orden->observacion;
        $bitacora->save();

        $bitacorap = new Bitacora;
        $bitacorap->id_orden=0;
        $bitacorap->id_presupuesto=$presupuesto->id_presupuesto;
        $bitacorap->id_usuario=$user->id_user;
        $bitacorap->id_estado=6;
        $bitacorap->id_comentario=10;
        $bitacorap->observacion='AUTORIZADO POR CLIENTE';
        $bitacorap->archivo='';
        $bitacorap->save();

        return array('code'=>'200','message'=>'Orden generada con exito');
      }else{
        return array('code'=>'500','message'=>'Presupuesto no valido');
      }
    }

    public function getarchivos($id){
      $bitacora=Bitacora::findOrFail($id);
      return response()->download(storage_path()."/app/presupuestos/".$bitacora->archivo);
    }
    public function sucursales($id){
      return Sucursales::where('id_cliente',$id)->where('estado',1)->orderBy('nombre')->get();
    }
    public function productos($id){
      return Productos::where('id_categoria',$id)->where('estado',1)->orderBy('producto')->get();;
    }
    public function getproducto($id){
      return Productos::select('sys_10_producto.id_producto','sys_10_producto.codigo','producto','sys_09_categorias.nombre as categoria','sys_10_producto.descripcion')->leftJoin('sys_09_categorias', 'sys_09_categorias.id_categoria', '=', 'sys_10_producto.id_categoria')->where('id_producto',$id)->where('sys_10_producto.estado',1)->get();
    }
}
