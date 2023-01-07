<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->id('stock_in_id');

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('item_id')->on('items')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->double('qty_in')->default(0);
            $table->double('price')->default(0);
            $table->date('stock_in_date')->nullable();

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
        Schema::dropIfExists('stock_ins');
    }
}
