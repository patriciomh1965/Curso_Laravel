<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $table = 'sys_16_presupuesto';
    protected $primaryKey='id_presupuesto';

    public function Clientes(){
    	return $this->belongsTo('App\Models\Clientes','id_cliente');
    }
    public function Sucursales(){
    	return $this->belongsTo('App\Models\Sucursales','id_sucursal');
    }
    public function Usuarios(){
    	return $this->belongsTo('App\User','id_user');
    }
    public function Estados(){
        return $this->belongsTo('App\Models\Estados','id_estado');
    }
    public function TipoRequerimiento(){
        return $this->belongsTo('App\Models\TipoRequerimiento','id_tipo_requerimiento');
    }
}
