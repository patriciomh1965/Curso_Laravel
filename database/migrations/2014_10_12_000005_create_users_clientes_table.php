<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_05_usuarios_clientes', function (Blueprint $table) {
            $table->increments('id_usuarios_cliente');
            $table->unsignedInteger('id_user')->key();
            $table->unsignedInteger('id_cliente')->key();
            $table->foreign('id_cliente')->references('id_cliente')->on('sys_04_clientes');
            $table->foreign('id_user')->references('id_user')->on('sys_00_users');
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
        Schema::dropIfExists('sys_05_usuarios_clientes');
    }
}