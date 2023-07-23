<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('clinicName');
            $table->string('clinicDescription');
            $table->string('clinicAddress');
            $table->string('clinicNumber');
            $table->string('birLicense');
            $table->string('clinicPaymentInfo')->nullable();
            $table->string('clinicMainPhoto')->nullable();
            $table->boolean('clinicStatus')->default(0);
            $table->date('birLicenseExpiry');
            $table->integer('subscriptionDuration')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinics');
    }
}
