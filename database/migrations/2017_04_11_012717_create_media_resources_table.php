<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resourcetable_type');
            $table->integer('resourcetable_id');
            $table->string('url');
            $table->string('name');
            $table->integer('order')->default(1);
            $table->integer('duration')->default(0);
            $table->tinyInteger('status')->default(1)->reference('id')->on('article_status');
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
        Schema::dropIfExists('media_resources');
    }
}
