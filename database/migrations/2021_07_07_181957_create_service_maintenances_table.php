<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_maintenances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('serviceId');
            $table->string('docType')->nullable();
            $table->string('complainType')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('service_maintenances');
    }
}
