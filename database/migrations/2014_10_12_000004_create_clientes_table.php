<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_04_clientes', function (Blueprint $table) {
            $table->increments('id_cliente');
            $table->string('cliente',255);
            $table->string('descripcion',255);
            $table->string('imagen',255);
            $table->string('codigo',50);
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
        Schema::dropIfExists('sys_04_clientes');
    }
}