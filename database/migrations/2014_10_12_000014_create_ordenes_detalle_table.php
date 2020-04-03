<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenesDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_13_ordenes_detalle', function (Blueprint $table) {
            $table->increments('id_orden_detalle');
            $table->unsignedInteger('id_orden');
            $table->unsignedInteger('id_producto');
            $table->unsignedInteger('id_cliente')->key();
            $table->unsignedInteger('cantidad');
            $table->unsignedInteger('valor_unitario');
            $table->unsignedInteger('valor_total');
            $table->unsignedInteger('id_estado');
            $table->foreign('id_orden')->references('id_orden')->on('sys_12_ordenes');
            $table->foreign('id_producto')->references('id_producto')->on('sys_10_producto');
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
        Schema::dropIfExists('sys_13_ordenes_detalle');
    }
}