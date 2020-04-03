<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_02_sucursales', function (Blueprint $table) {
            $table->increments('id_sucursal');
            $table->string('nombre',255);
            $table->string('direccion',255);
            $table->string('codigo',50)->key();
            $table->string('latitud',100);
            $table->string('longitud',100);
            $table->unsignedInteger('id_cliente')->key();
            $table->unsignedInteger('id_comuna')->key();
            $table->foreign('id_cliente')->references('id_cliente')->on('sys_04_clientes');
            $table->foreign('id_comuna')->references('id_comuna')->on('sys_08_comunas');
            $table->boolean('estado')->key();
            $table->boolean('casa_matriz');
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
        Schema::dropIfExists('sys_02_sucursales');
    }
}