<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'sys_20_bitacora';
    protected $primaryKey='id_bitacora';
    public function Comentarios(){
    	return $this->belongsTo('App\Models\Comentarios','id_comentario');
    }
    public function Usuarios(){
    	return $this->belongsTo('App\User','id_usuario');
    }
    public function Estados(){
    	return $this->belongsTo('App\Models\Estados','id_estado');
    }
}
