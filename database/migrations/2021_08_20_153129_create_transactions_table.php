<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userId');
            $table->unsignedInteger('serviceId');
            $table->string('status');
            $table->timestamps();
            $table->foreign('userId')
            ->references('id') 
            ->on('users') 
            ->onDelete('cascade');
            $table->foreign('serviceId')
            ->references('id') 
            ->on('services') 
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
