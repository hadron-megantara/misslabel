<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id');
            $table->integer('product_detail_id');
            $table->string('material_type');
            $table->integer('color_id');
            $table->integer('total_product');
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
        Schema::dropIfExists('store_stocks');
    }
}
