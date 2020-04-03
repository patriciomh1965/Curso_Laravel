<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCliente extends Model
{
    protected $table = 'sys_05_usuarios_clientes';
    protected $primaryKey='id_usuarios_cliente';
    public $timestamps = false;
}
