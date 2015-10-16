<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->double('debit');
            $table->double('credit');
            $table->datetime('expired_date');
            $table->string('notes');
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
        Schema::drop('point_logs');
    }
}
