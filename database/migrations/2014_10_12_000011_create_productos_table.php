<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_10_producto', function (Blueprint $table) {
            $table->increments('id_producto');
            $table->string('producto',255);
            $table->string('codigo',50)->key();
            $table->string('descripcion',255);
            $table->string('imagen',400);
            $table->unsignedInteger('min_stock');
            $table->unsignedInteger('precio');
            $table->unsignedInteger('id_categoria')->key();
            $table->foreign('id_categoria')->references('id_categoria')->on('sys_09_categorias');
            $table->boolean('estado')->key();
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
        Schema::dropIfExists('sys_10_producto');
    }
}