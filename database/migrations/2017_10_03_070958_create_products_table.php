<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_detail_id');
            $table->string('material_type');
            $table->string('color');
            $table->integer('length');
            $table->string('description')->nullable();
            $table->integer('total');
            $table->string('unit');
            $table->char('status')->default('0');
            $table->integer('convection_id')->nullable();
            $table->integer('warehouse_id')->nullable();
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
        Schema::dropIfExists('products');
    }
}
