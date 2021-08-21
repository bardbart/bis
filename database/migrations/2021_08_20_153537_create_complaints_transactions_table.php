<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transId');
            $table->string('compType');
            $table->string('compDetails');
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
        Schema::dropIfExists('complaints_transactions');
    }
}
