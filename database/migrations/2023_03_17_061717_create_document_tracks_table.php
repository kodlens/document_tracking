<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_tracks', function (Blueprint $table) {
            $table->id('document_track_id');

            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')->references('document_id')->on('documents')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('route_id');
            $table->foreign('route_id')->references('route_id')->on('routes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('route_detail_id');
            $table->foreign('route_detail_id')->references('route_detail_id')->on('route_details')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('office_id');
            $table->foreign('office_id')->references('office_id')->on('offices')
                ->onUpdate('cascade')->onDelete('cascade');


            $table->integer('order_no')->default(0);
            $table->tinyInteger('is_origin')->default(0);
            $table->tinyInteger('is_last')->default(0);
            $table->tinyInteger('is_forward_from')->default(0);
            $table->tinyInteger('is_received')->default(0);

            $table->dateTime('datetime_received')->nullable();
            $table->string('receive_remarks')->nullable();

            $table->tinyInteger('is_process')->default(0);
            $table->dateTime('datetime_process')->nullable();
            $table->string('process_remarks')->nullable();
            $table->tinyInteger('is_done')->default(0);
            $table->dateTime('datetime_done')->nullable();
            $table->string('done_remarks')->nullable();

            $table->tinyInteger('is_forwarded')->default(0);
            $table->dateTime('datetime_forwarded')->nullable();
            $table->string('forward_remarks')->nullable();

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
        Schema::dropIfExists('document_tracks');
    }
}
