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
            $table->unsignedInteger('availedServiceId');
            $table->string('transMode')->nullable();
            $table->string('purpose')->nullable();
            $table->string('paymentMode')->nullable();
            $table->longText('complainDetails')->nullable();
            $table->string('respondents')->nullable();
            $table->string('respondentsAdd')->nullable();
            $table->string('blotterDetails')->nullable();
            $table->string('barangayIdPath')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('availedServiceId')
                ->references('id')
                ->on('availed_services')
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
