<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_16_presupuesto', function (Blueprint $table) {
            $table->increments('id_presupuesto');
            $table->unsignedInteger('id_cliente')->key();
            $table->unsignedInteger('id_tipo_requerimiento')->key();
            $table->unsignedInteger('id_sucursal');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_user_autorizado')->nullable();
            $table->unsignedInteger('id_estado');
            $table->string('npresupuesto',10);
            $table->string('observacion',255);
            $table->string('archivo',500)->nullable();
            $table->string('solicitante',255);
            $table->integer('totalvalor');
            $table->integer('totalproductos');
            $table->datetime('fecha_solicitud');
            $table->foreign('id_cliente')->references('id_cliente')->on('sys_04_clientes');
            $table->foreign('id_tipo_requerimiento')->references('id_tipo_requerimiento')->on('sys_18_tipo_requerimiento');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sys_02_sucursales');
            $table->foreign('id_user')->references('id_user')->on('sys_00_users');
            $table->foreign('id_user_autorizado')->references('id_user')->on('sys_00_users');
            $table->foreign('id_estado')->references('id_estado')->on('sys_11_estado');
            $table->timestamps();
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
        Schema::dropIfExists('sys_16_presupuesto');
    }
}