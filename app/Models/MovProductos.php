<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovProductos extends Model
{
    protected $table = 'sys_14_mov_productos';
    protected $primaryKey='id_movimiento';
    public function Productos(){
    	return $this->belongsTo('App\Models\Productos','id_producto');
    }
    public function Usuarios(){
    	return $this->belongsTo('App\User','id_user_responsable','id_user');
    }
}
