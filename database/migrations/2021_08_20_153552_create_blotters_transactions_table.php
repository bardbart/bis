<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlottersTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blotters_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transId');
            $table->string('blotType')->nullable();
            $table->string('blotDetails');
            $table->string('respondents')->nullable();
            $table->string('respondentsAdd')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();
            $table->foreign('transId')
            ->references('id') 
            ->on('transactions') 
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
        Schema::dropIfExists('blotters_transactions');
    }
}
