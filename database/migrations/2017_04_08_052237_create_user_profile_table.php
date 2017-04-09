<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('related_account_id')->nullable()->references('id')->on('users');
            $table->integer('airport_id')->nullable()->references('id')->on('airports');
            $table->string('title')->nullable();
            $table->string('position')->nullable();
            $table->string('organization')->nullable();
            $table->integer('country_id')->nullable()->references('id')->on('countries');
            $table->integer('language_id')->nullable()->references('id')->on('languages');
            $table->string('phone')->nullable();
            $table->tinyInteger('gender')->default(1);
            $table->string('location')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
//            $table->integer('instagram_id')->nullable();
//            $table->string('instagram_photo')->nullable();
//            $table->string('instagram_name')->nullable();
//            $table->integer('facebook_id')->nullable();
//            $table->string('facebook_photo')->nullable();
//            $table->string('facebook_name')->nullable();
//            $table->integer('linkedin_id')->nullable();
//            $table->string('linkedin_photo')->nullable();
//            $table->string('linkedin_name')->nullable();
//            $table->integer('weixin_id')->nullable();
//            $table->string('weixin_photo')->nullable();
//            $table->string('weixin_name')->nullable();
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profile');
    }
}
