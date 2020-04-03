<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model
{
    protected $table = 'sys_07_ciudad';
    protected $primaryKey='id_ciudad';
    public $timestamps = false;

    public function Regiones(){
    	return $this->belongsTo('App\Models\Regiones','id_region');
    }
}
