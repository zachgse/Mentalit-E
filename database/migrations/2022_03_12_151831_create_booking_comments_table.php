<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_comments', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('referTo');
            $table->string('reason');
            $table->string('diagnosis');
            $table->string('fileUpload');
            $table->dateTime('dateTime');
            $table->boolean('permission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_comments');
    }
}
