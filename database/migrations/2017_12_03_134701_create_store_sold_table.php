<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreSoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_sold', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_detail_id');
            $table->integer('store_id');
            $table->integer('total_product');
            $table->integer('total_price');
            $table->float('discount_percentage', 5, 4)->nullable();
            $table->integer('discount_amount')->nullable();
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
        Schema::dropIfExists('store_sold');
    }
}
