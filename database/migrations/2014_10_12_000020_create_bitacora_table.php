<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_20_bitacora', function (Blueprint $table) {
            $table->increments('id_bitacora');
            $table->unsignedInteger('id_orden')->nullable()->key();
            $table->unsignedInteger('id_presupuesto')->nullable()->key();
            $table->unsignedInteger('id_usuario')->key();
            $table->unsignedInteger('id_estado');
            $table->unsignedInteger('id_comentario')->nullable();
            $table->string('archivo',100)->nullable();
            $table->string('observacion',100);
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
        Schema::dropIfExists('sys_20_bitacora');
    }
}