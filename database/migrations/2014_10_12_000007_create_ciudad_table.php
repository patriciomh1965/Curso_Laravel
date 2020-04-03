<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiudadTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_07_ciudad', function (Blueprint $table) {
            $table->increments('id_ciudad');
            $table->string('ciudad',100)->unique();
            $table->string('capital',100);
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
        Schema::dropIfExists('sys_07_ciudad');
    }
}
