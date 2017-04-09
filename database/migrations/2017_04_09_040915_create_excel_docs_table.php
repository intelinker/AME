<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcelDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excel_docs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('document_id')->references('id')->on('documents');
            $table->string('MODEL');
            $table->string('LOCATION');
            $table->integer('ATA');
            $table->integer('CB_DESIGNTION');
            $table->string('PNL');
            $table->string('FTN');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excel_docs');
    }
}
