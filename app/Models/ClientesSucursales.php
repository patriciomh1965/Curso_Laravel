<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientesSucursales extends Model
{
    protected $table = 'sys_06_clientes_sucursales';
    protected $primaryKey='id_clientes_sucursales';
    public $timestamps = false;
}
