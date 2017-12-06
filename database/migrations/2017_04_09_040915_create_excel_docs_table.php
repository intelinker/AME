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
            $table->integer('document_id')->references('id')->on('documents');
            $table->string('Model');
            $table->string('Coordinate');
            $table->integer('ATA');
            $table->string('C/B_Designation');
            $table->string('PNL');
            $table->string('FTN');
            $table->string('Remark');
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
