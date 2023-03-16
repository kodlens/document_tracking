<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_details', function (Blueprint $table) {
            $table->id('route_detail_id');

            $table->unsignedBigInteger('route_id');
            $table->foreign('route_id')->references('route_id')->on('routes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('route_id')->default(0);

            $table->unsignedBigInteger('office_id');
            $table->foreign('office_id')->references('office_id')->on('offices')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->tinyInteger('is_origin')->default(0);
            $table->tinyInteger('is_last')->default(0);

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
        Schema::dropIfExists('route_details');
    }
}
