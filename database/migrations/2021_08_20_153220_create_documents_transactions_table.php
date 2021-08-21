<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transId');
            $table->unsignedInteger('dmId');
            $table->string('purpose');
            $table->string('barangayIdPath');
            $table->string('reason')->nullable();
            $table->timestamps();
            $table->foreign('transId')
            ->references('id') 
            ->on('transactions') 
            ->onDelete('cascade');
            $table->foreign('dmId')
            ->references('id') 
            ->on('document_types') 
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
        Schema::dropIfExists('documents_transactions');
    }
}
