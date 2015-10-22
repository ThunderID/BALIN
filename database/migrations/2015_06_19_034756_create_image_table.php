<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('imageable_id')->unsigned()->index();
            $table->string('imageable_type', 255);
            // $table->integer('user_id')->unsigned()->index();
            // $table->string('user_type', 255);
            // $table->integer('courier_id')->unsigned()->index();
            // $table->string('courier_type', 255);
            $table->string('thumbnail', 255);
            $table->string('image_xs', 255);
            $table->string('image_sm', 255);
            $table->string('image_md', 255);
            $table->string('image_l', 255);
            $table->datetime('published_at');
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
        Schema::drop('images');
    }
}
