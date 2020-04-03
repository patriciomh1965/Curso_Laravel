<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_12_ordenes', function (Blueprint $table) {
            $table->increments('id_orden');
            $table->unsignedInteger('id_cliente')->key();
            $table->unsignedInteger('id_sucursal');
            $table->unsignedInteger('id_user_asignado')->nullable();
            $table->unsignedInteger('id_user_creador');
            $table->unsignedInteger('id_estado');
            $table->unsignedInteger('id_tipo_requerimiento');
            $table->unsignedInteger('id_presupuesto')->nullable();
            $table->string('npresupuesto',10);
            $table->string('solicitante',255)->nullable();
            $table->string('observacion',255)->nullable();
            $table->string('observacion_cliente',255)->nullable();
            $table->integer('totalvalor');
            $table->integer('totalproductos');
            $table->dateTime('fecha_estimada')->key();
            $table->foreign('id_cliente')->references('id_cliente')->on('sys_04_clientes');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sys_02_sucursales');
            $table->foreign('id_user_asignado')->references('id_user')->on('sys_00_users');
            $table->foreign('id_user_creador')->references('id_user')->on('sys_00_users');
            $table->foreign('id_estado')->references('id_estado')->on('sys_11_estado');
            $table->foreign('id_tipo_requerimiento')->references('id_tipo_requerimiento')->on('sys_18_tipo_requerimiento');
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
        Schema::dropIfExists('sys_12_ordenes');
    }
}