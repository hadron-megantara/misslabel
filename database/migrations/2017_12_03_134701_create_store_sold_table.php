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
            $table->integer('store_transaction_id');
            $table->integer('store_stock_id');
            $table->integer('price');
            $table->integer('total_price');
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
        Schema::dropIfExists('store_sold');
    }
}
