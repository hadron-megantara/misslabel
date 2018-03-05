<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id');
            $table->string('name');
            $table->unsignedInteger('size');
            $table->string('mime');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE delivery_notes ADD file LONGBLOB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_notes');
    }
}
