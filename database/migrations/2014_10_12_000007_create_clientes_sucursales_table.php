<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_06_clientes_sucursales', function (Blueprint $table) {
            $table->increments('id_clientes_sucursales');
            $table->unsignedInteger('id_cliente')->key();
            $table->unsignedInteger('id_sucursal')->key();
            $table->foreign('id_cliente')->references('id_cliente')->on('sys_04_clientes');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sys_02_sucursales');
            $table->engine = 'InnoDB'; 
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('sys_06_clientes_sucursales');
    }
}