<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunas extends Model
{
    protected $table = 'sys_08_comunas';
    protected $primaryKey='id_comuna';
    public $timestamps = false;

    public function Ciudades(){
    	return $this->belongsTo('App\Models\Ciudades','id_ciudad');
    }
}
