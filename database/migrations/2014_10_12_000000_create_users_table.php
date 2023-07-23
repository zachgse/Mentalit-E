<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('middleName')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('userType');
            $table->date('birthDate');
            $table->string('gender');
            $table->string('contactNo');
            $table->string('zipCode');
            $table->string('city');
            $table->string('barangay');
            $table->string('streetNumber');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_image')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('consent');
            $table->integer('warningCount')->default(0);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
