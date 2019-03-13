<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabaseSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('country_id')->index();
            $table->string('ip')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->index();
            $table->string('video_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->index();
            $table->string('video_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('watches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->index();
            $table->string('video_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
