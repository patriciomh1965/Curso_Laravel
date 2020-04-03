<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestosDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_17_presupuesto_detalle', function (Blueprint $table) {
            $table->increments('id_presupuesto_detalle');
            $table->unsignedInteger('id_presupuesto');
            $table->unsignedInteger('id_producto');
            $table->unsignedInteger('cantidad');
            $table->unsignedInteger('valor_unitario');
            $table->unsignedInteger('valor_total');
            $table->foreign('id_presupuesto')->references('id_presupuesto')->on('sys_16_presupuesto');
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
        Schema::dropIfExists('sys_17_presupuesto_detalle');
    }
}