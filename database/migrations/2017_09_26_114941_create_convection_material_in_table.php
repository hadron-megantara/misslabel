<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvectionMaterialInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convection_material_in', function (Blueprint $table) {
            $table->increments('id');
            $table->char('status')->default('0');
            $table->string('description')->nullable();
            $table->string('material_type');
            $table->integer('color_id');
            $table->integer('length');
            $table->integer('convection_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convection_material_in');
    }
}
