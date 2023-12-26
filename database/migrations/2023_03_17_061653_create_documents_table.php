<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('tracking_no')->nullable();
            $table->string('document_name')->nullable();


            $table->unsignedBigInteger('route_id');
            $table->foreign('route_id')->references('route_id')->on('routes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->tinyInteger('is_done')->nullable()
                ->default(0);
                
            $table->dateTime('datetime_done')
                ->nullable();

            $table->tinyInteger('is_forwarded')->nullable()
                ->default(0);

            $table->dateTime('fowarded_datetime')
                ->nullable();

                
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
        Schema::dropIfExists('documents');
    }
}
