<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_setup', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users');
            $table->tinyInteger('privacy_protected')->default(0);
            $table->tinyInteger('friends_found')->default(1);
            $table->tinyInteger('phone_found')->default(1);
            $table->tinyInteger('notice_point')->default(1);
            $table->tinyInteger('notice_sound')->default(1);
            $table->tinyInteger('recieve_local_aog')->default(1);
            $table->tinyInteger('recieve_global_aog')->default(1);
            $table->tinyInteger('aog_support')->default(1);
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
        Schema::dropIfExists('user_setup');
    }
}
