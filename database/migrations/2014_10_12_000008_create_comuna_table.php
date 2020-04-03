<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComunaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_08_comunas', function (Blueprint $table) {
            $table->increments('id_comuna');
            $table->string('comuna',100)->unique();
            $table->unsignedInteger('id_ciudad')->key();
            $table->foreign('id_ciudad')->references('id_ciudad')->on('sys_07_ciudad');
            $table->unsignedInteger('id_region')->key();
            $table->foreign('id_region')->references('id_region')->on('sys_06_region');
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
        Schema::dropIfExists('sys_08_comunas');
    }
}
