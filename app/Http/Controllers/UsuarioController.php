<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;
use App\User;
use App\Models\Perfil;
use App\Models\Clientes;
use App\Models\UserCliente;

class UsuarioController extends Controller
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
        $usuarios=User::all();
        $code=$request->session()->get('code');
        $message=$request->session()->get('message');
        return view('layouts.usuarios',['code'=>$code,'message'=>$message,'usuarios'=>$usuarios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $perfiles=Perfil::where('estado',1)->get();
        return view('layouts.usuarios_save',['perfiles'=>$perfiles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request)
    {
        try{
            $usuario = new User;
            $usuario->name=$request->get('name');
            $usuario->email=$request->get('email');
            $usuario->password=\Hash::make($request->get('password'));
            $usuario->id_perfil=$request->get('perfil');
            $usuario->estado=1;
            $usuario->save();
            return redirect('usuarios')->with(array('code'=>'200','message'=>'Registrado Creado Correctamente'));
        }catch(\Exception $e){
            return redirect('usuarios')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
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
            $perfiles = Perfil::get();
            $usuario  = User::findOrFail($id);
            return view('layouts.usuarios_save',['perfiles'=>$perfiles,'usuario'=>$usuario]); 
        }catch (\ModelNotFoundException $e){   
            return redirect('usuarios')->with(array('code'=>401,'message'=>'Usuario no encontrado'));
        }catch(\Exception $e){
            return redirect('usuarios')->with(array('code'=>500,'message'=>$e->getCode().' '.$e->getMessage()));
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
    public function update(UsuarioRequest $request, $id)
    {
        try{
            $usuario = User::findOrFail($id);
            $usuario->name=$request->get('name');
            $usuario->email=$request->get('email');
            $usuario->id_perfil=$request->get('perfil');
            $usuario->estado=$request->get('estado');
            $usuario->save();
            return redirect('usuarios')->with(array('code'=>'200','message'=>'Registrado Actualizado Correctamente'));
        }catch(\Exception $e){
            return redirect('usuarios')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
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

    public function usuariosclientes(Request $request, $id){

        $clientes=Clientes::where('estado',1)->get();
        $usuario=User::where('id_user',$id)->first();
        $usuarioclientes=UserCliente::where('id_user',$id)->get();
        return view('layouts.usuarios_cliente',['clientes'=>$clientes,'usuario'=>$usuario,'usuarioclientes'=>$usuarioclientes]); 
    }

    public function save_usuariosclientes(Request $request){

        try{
            $clientes=$request->get('clientes');
            $user=$request->get('id_user');
            if(count($clientes) > 0)
            {            
                UserCliente::where('id_user',$user)->delete();
                foreach ($clientes as $key => $value) {
                    $usuario_cliente = new UserCliente;
                    $usuario_cliente->id_cliente=$value;
                    $usuario_cliente->id_user=$user;
                    $usuario_cliente->save();
                }
                return redirect('usuarios')->with(array('code'=>'200','message'=>'Registrado Actualizado Correctamente'));
            }else{
                UserCliente::where('id_user',$user)->delete();
                return redirect('usuarios')->with(array('code'=>'200','message'=>'Registrado Actualizado Correctamente'));
            }
        }catch(\Exception $e){
            return redirect('usuarios')->with(array('code'=>'500','message'=>$e->getCode().' '.$e->getMessage()));
        }
    }
}
