<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserCliente;
use App\Models\Clientes;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'sys_00_users';
    protected $primaryKey='id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','id_perfil',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function Perfiles(){
        return $this->belongsTo('App\Models\Perfil','id_perfil');
    }

    public function GetClienteUser(){
        $user    = auth()->user();
        $getcliente= UserCliente::select('id_cliente')->where('id_user',$user->id_user)->get();
        $clientes =Clientes::whereIn('id_cliente',$getcliente)->get();
        return $clientes;
    }
}
