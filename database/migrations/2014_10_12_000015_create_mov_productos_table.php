<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_14_mov_productos', function (Blueprint $table) {
            $table->increments('id_movimiento');
            $table->unsignedInteger('id_producto')->key();
            $table->unsignedInteger('id_user_responsable')->key();
            $table->string('codigo_ingreso',50)->key();
            $table->string('tipo',50);
            $table->unsignedInteger('precio');
            $table->integer('cantidad');
            $table->dateTime('fecha_ingreso')->key();
            $table->foreign('id_producto')->references('id_producto')->on('sys_10_producto');
            $table->foreign('id_user_responsable')->references('id_user')->on('sys_00_users');
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
        Schema::dropIfExists('sys_14_mov_productos');
    }
}