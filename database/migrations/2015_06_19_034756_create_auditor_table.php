<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('table_id')->unsigned()->index();
            $table->string('table_type', 255);
            $table->date('ondate');
            $table->string('event', 255);
            $table->text('action');
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
        Schema::drop('auditors');
    }
}