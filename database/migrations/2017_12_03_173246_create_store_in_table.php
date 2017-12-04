<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_in', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_detail_id');
            $table->integer('warehouse_store_id');
            $table->integer('total_product');
            $table->string('material_type');
            $table->string('color');
            $table->char('status')->default(0);
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
        Schema::dropIfExists('store_in');
    }
}
