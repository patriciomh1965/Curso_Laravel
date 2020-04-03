<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresupuestoDetalle extends Model
{
    protected $table = 'sys_17_presupuesto_detalle';
    protected $primaryKey='id_presupuesto_detalle';

    public function Presupuestos(){
    	return $this->belongsTo('App\Models\Presupuestos','id_presupuesto');
    }
    public function Productos(){
    	return $this->belongsTo('App\Models\Productos','id_producto');
    }
}
