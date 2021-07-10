<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficialsPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officials_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('boId');
            $table->string('positionName');
            $table->timestamps();
            $table->foreign('boId')
                ->references('id')
                ->on('barangay_officials')
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
        Schema::dropIfExists('officials_positions');
    }
}
