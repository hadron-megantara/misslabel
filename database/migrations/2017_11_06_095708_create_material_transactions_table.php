<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seller');
            $table->string('description');
            $table->integer('price');
            $table->date('date_purchase');
            $table->string('name');
            $table->unsignedInteger('size');
            $table->string('mime');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE material_transactions ADD file LONGBLOB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_transactions');
    }
}
