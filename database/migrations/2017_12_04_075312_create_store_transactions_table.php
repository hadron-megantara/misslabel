<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_type_id');
            $table->integer('store_id');
            $table->integer('price');
            $table->integer('final_price');
            $table->float('discount_percentage', 5, 4)->nullable();
            $table->integer('discount_amount')->nullable();
            $table->date('date');
            $table->string('file_path')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('store_transactions');
    }
}
