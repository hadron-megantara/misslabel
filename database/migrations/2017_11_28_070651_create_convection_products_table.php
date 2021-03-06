<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvectionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convection_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('convection_id');
            $table->integer('payment_type_id');
            $table->string('description');
            $table->integer('price');
            $table->string('file_path')->nullable();
            $table->char('status')->default('0');
            $table->date('date')->nullable();
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
        Schema::dropIfExists('convection_products');
    }
}
