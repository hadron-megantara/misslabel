<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('material_type');
            $table->integer('length');
            $table->string('color');
            $table->string('description');
            $table->integer('price');
            $table->date('date_purchase');
            $table->date('date_convection')->nullable();
            $table->date('date_converted')->nullable();
            $table->integer('convection_id')->nullable();
            $table->char('status')->default('0');
            $table->char('status_converted')->default('0');
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
        Schema::dropIfExists('materials');
    }
}
