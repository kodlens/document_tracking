<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id('item_id');
            $table->string('barcode')->nullable()->default('');
            $table->string('serial')->nullable()->default('');
            $table->string('brand')->nullable()->default('');
            $table->string('model')->nullable()->default('');
            $table->string('item_name')->nullable()->default('');
            $table->string('item_description')->nullable()->default('');
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('items');
    }
}
