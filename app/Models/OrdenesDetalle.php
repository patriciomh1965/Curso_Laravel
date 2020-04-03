<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenesDetalle extends Model
{
    protected $table = 'sys_13_ordenes_detalle';
    protected $primaryKey='id_orden_detalle';

    public function Ordenes(){
    	return $this->belongsTo('App\Models\Ordenes','id_orden');
    }
    public function Productos(){
    	return $this->belongsTo('App\Models\Productos','id_producto');
    }
    public function Clientes(){
    	return $this->belongsTo('App\Models\Clientes','id_cliente');
    }
}
