<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursales extends Model
{
    protected $table = 'sys_02_sucursales';
    protected $primaryKey='id_sucursal';

    public function Clientes(){
    	return $this->belongsTo('App\Models\Clientes','id_cliente');
    }
    public function Comunas(){
    	return $this->belongsTo('App\Models\Comunas','id_comuna');
    }
}
