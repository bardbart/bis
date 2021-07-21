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
            $table->increments('id');
            $table->string('password');
            $table->string('lastName');
            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->bigInteger('contactNo');
            $table->string('houseNo');
            $table->string('street');
            $table->string('zipCode');
            $table->string('city');
            $table->string('province');
            $table->date('dob');
            $table->string('gender');
            $table->string('civilStatus');
            $table->string('citizenship');
            $table->boolean('activeStatus')->default(1);
            $table->string('acctStatus')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
